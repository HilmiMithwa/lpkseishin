<?php


namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\Modul;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 


//Nunggu dashboard guru keluar
class ModulController extends Controller
{

    public function index() 
    {
        //ini buat ditunjukin ke siswanya 

        $modul = Modul::with(['mapel', 'rps'])->get();

        return view('students.module-detail', compact('modul'));
    }

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
        $isEnrolled = $user->mapels()->where('mapel.id_mapel', $id_mapel)->exists();

        if (!$isEnrolled) {
            abort(403, 'NO ACCESS! Kamu belum terdaftar di kelas ini.');
        }

        try {
            // 4. Ambil data bahan_ajar dari database
            $currentModul->materials = DB::table('bahan_ajar')
                ->where('id_modul', $id_modul)
                ->get();

            // 5. AMBIL DATA TUGAS ASLI DB + JOIN STATUS PENGIRIMAN SISWA YANG LOGIN
            $currentModul->tasks = DB::table('tugas')
                ->leftJoin('pengiriman_tugas', function ($join) {
                    $join->on('tugas.id_tugas', '=', 'pengiriman_tugas.id_tugas')
                        ->where('pengiriman_tugas.id_user', '=', Auth::id());
                })
                ->where('tugas.id_modul', $id_modul)
                ->select('tugas.*', 'pengiriman_tugas.status as submission_status')
                ->get();
        } catch (\Exception $e) {
            // Fallback jika terjadi kendala struktural database
            $currentModul->materials = collect([]);
            $currentModul->tasks = collect([]);
        }

        // 6. Memaksa dummy data Evaluation muncul untuk mockup layout figma
        //$currentModul->evaluation = (object)[
        //    'id' => 1,
        //    'title' => 'N4 and Kanji Evaluation',
        //    'type' => 'Test',
        //    'date' => '21 May 2026',
        //    'duration' => 60
        //];

        // Ambil data mapel untuk navigasi sidebar kanan
        $subject = Mapel::with('modul')->findOrFail($id_mapel);

        return view('students.module-detail', compact('currentModul', 'subject'));
    }

    

    
}
