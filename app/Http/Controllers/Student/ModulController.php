<?php


namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\Modul;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use App\Models\BahanAjar;
use App\Models\Tugas;
use App\Models\Announcement;


//Nunggu dashboard guru keluar
class ModulController extends Controller
{

    
    public function showModule($id_mapel, $id_modul)
    {
        // 1. Ambil data modul dasarnya berdasarkan ID modul yang benar
        $currentModul = Modul::findOrFail($id_modul);

        // 2. VALIDASI SILANG: Pastikan modul ini memang bagian dari mata pelajaran di URL
        if ($currentModul->id_mapel != $id_mapel) {
            abort(404, 'Modul tidak ditemukan di dalam mata pelajaran ini.');
        }

        // 3. BARIKADE KEAMANAN (IDOR): Cek kontrak belajar siswa pada kelas ini
        /** @var User $user */
        $user = Auth::user();
        $userId = $user->id;
        $isEnrolled = $user->activeMapels()->where('id_mapel', $id_mapel)->exists();

        if (!$isEnrolled) {
            abort(403, 'NO ACCESS! Kamu belum terdaftar di kelas ini.');
        }

        // 3.5 BARIKADE KEAMANAN: Cek Akses Berurutan
        if ($currentModul->is_sequential) {
            $previousModul = Modul::where('id_mapel', $id_mapel)
                                  ->where('id_modul', '<', $id_modul)
                                  ->orderBy('id_modul', 'desc')
                                  ->first();
            
            if ($previousModul) {
                // Calculate previous module progress
                $prevTotalMaterial = BahanAjar::where('id_modul', $previousModul->id_modul)->count();
                $prevCompletedMaterial = DB::table('bahan_ajar')
                    ->join('bahan_ajar_progress', 'bahan_ajar.id_bahan_ajar', '=', 'bahan_ajar_progress.id_bahan_ajar')
                    ->where('bahan_ajar.id_modul', $previousModul->id_modul)
                    ->where('bahan_ajar_progress.id_user', $userId)
                    ->where('bahan_ajar_progress.is_complete', DB::raw('true'))
                    ->count();

                $prevTotalTask = Tugas::where('id_modul', $previousModul->id_modul)->count();
                $prevCompletedTask = Tugas::join('pengiriman_tugas', 'tugas.id_tugas', '=', 'pengiriman_tugas.id_tugas')
                    ->where('tugas.id_modul', $previousModul->id_modul)
                    ->where('pengiriman_tugas.id_user', $userId)
                    ->where('pengiriman_tugas.status', 'dikirim')
                    ->count();

                $evaluasis = \App\Models\Evaluasi::where('id_modul', $previousModul->id_modul)->get();
                $prevTotalEvaluasi = $evaluasis->count();
                $prevCompletedEvaluasi = 0;
                foreach($evaluasis as $ev) {
                    if(DB::table('catatan_evaluasi')->where('id_user', $userId)->where('id_mapel', $id_mapel)->where('nama_evaluasi', $ev->judul)->exists()) {
                        $prevCompletedEvaluasi++;
                    }
                }

                $prevTotalItems = $prevTotalMaterial + $prevTotalTask + $prevTotalEvaluasi;
                $prevCompletedItems = $prevCompletedMaterial + $prevCompletedTask + $prevCompletedEvaluasi;
                $prevProgress = $prevTotalItems > 0 ? round(($prevCompletedItems / $prevTotalItems) * 100) : 0;

                if ($prevProgress < 100) {
                    abort(403, 'Akses Ditolak! Anda harus menyelesaikan modul sebelumnya terlebih dahulu.');
                }
            }
        }

        try {
            // 4. Ambil data bahan_ajar dari database
            $currentModul->materials = BahanAjar::leftJoin('bahan_ajar_progress', function ($join) use ($userId){
                    $join->on('bahan_ajar.id_bahan_ajar', '=', 'bahan_ajar_progress.id_bahan_ajar')
                        ->where('bahan_ajar_progress.id_user', '=', $userId);
                })
                ->where('bahan_ajar.id_modul', $id_modul)
                ->select('bahan_ajar.*', 'bahan_ajar_progress.is_complete as is_complete')
                ->get();
                

            // 5. AMBIL DATA TUGAS ASLI DB + JOIN STATUS PENGIRIMAN SISWA YANG LOGIN
            $currentModul->tasks = Tugas::
                leftJoin('pengiriman_tugas', function ($join) use ($userId) {
                    $join->on('tugas.id_tugas', '=', 'pengiriman_tugas.id_tugas')
                        ->where('pengiriman_tugas.id_user', '=', $userId);
                })

                ->where('tugas.id_modul', $id_modul)
                ->select('tugas.*', 'pengiriman_tugas.status as submission_status')
                ->get();

                // Real Evaluasi
                $evaluasis = \App\Models\Evaluasi::where('id_modul', $id_modul)->get();
                foreach($evaluasis as $evaluasi) {
                    $evaluasi->is_complete = DB::table('catatan_evaluasi')
                        ->where('id_user', $userId)
                        ->where('id_mapel', $id_mapel)
                        ->where('nama_evaluasi', $evaluasi->judul)
                        ->exists();
                }
                $currentModul->evaluasis = $evaluasis;
        } catch (\Exception $e) {
            // Fallback jika terjadi kendala struktural database
            $currentModul->materials = collect([]);
            $currentModul->tasks = collect([]);
        }



        // Ambil data mapel dan announcements untuk navigasi sidebar kanan
        $subject = Mapel::with(['modul', 'announcements'])->findOrFail($id_mapel);
        
        // Kalkulasi is_locked untuk sidebar daftar modul
        $previousModuleCompleted = true;
        foreach ($subject->modul as $modul) {
            $modul->total_material = BahanAjar::where('id_modul', $modul->id_modul)->count();
            $modul->completed_material = DB::table('bahan_ajar')
                ->join('bahan_ajar_progress', 'bahan_ajar.id_bahan_ajar', '=', 'bahan_ajar_progress.id_bahan_ajar')
                ->where('bahan_ajar.id_modul', $modul->id_modul)
                ->where('bahan_ajar_progress.id_user', $userId)
                ->where('bahan_ajar_progress.is_complete', DB::raw('true'))
                ->count();

            $modul->total_task = Tugas::where('id_modul', $modul->id_modul)->count();
            $modul->completed_task = Tugas::join('pengiriman_tugas', 'tugas.id_tugas', '=', 'pengiriman_tugas.id_tugas')
                ->where('tugas.id_modul', $modul->id_modul)
                ->where('pengiriman_tugas.id_user', $userId)
                ->where('pengiriman_tugas.status', 'dikirim')
                ->count();

            $evaluasis = \App\Models\Evaluasi::where('id_modul', $modul->id_modul)->get();
            $modul->total_evaluasi = $evaluasis->count();
            $modul->completed_evaluasi = 0;
            foreach($evaluasis as $ev) {
                if(DB::table('catatan_evaluasi')->where('id_user', $userId)->where('id_mapel', $id_mapel)->where('nama_evaluasi', $ev->judul)->exists()) {
                    $modul->completed_evaluasi++;
                }
            }

            $totalItems = $modul->total_material + $modul->total_task + $modul->total_evaluasi;
            $completedItems = $modul->completed_material + $modul->completed_task + $modul->completed_evaluasi;

            if ($totalItems > 0) {
                $modul->progress_percentage = round(($completedItems / $totalItems) * 100);
            } else {
                $modul->progress_percentage = 0;
            }

            // Fitur Akses Berurutan
            $modul->is_locked = false;
            if ($modul->is_sequential && !$previousModuleCompleted) {
                $modul->is_locked = true;
            }
            
            $previousModuleCompleted = ($modul->progress_percentage >= 100);
        }

        return view('students.module-detail', compact('currentModul', 'subject'));
    }

    

    
}
