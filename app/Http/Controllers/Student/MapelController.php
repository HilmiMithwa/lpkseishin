<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modul;
use App\Models\Mapel;       
use App\Models\BahanAjar;  
use App\Models\Tugas;      
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;   

class MapelController extends Controller
{
    public function showProgress($id_mapel, $id_modul = null) 
    {
        $user = Auth::user();
        $userId = $user->id;
        $subject = Mapel::with(['modul', 'announcements'])->findOrFail($id_mapel);

        $currentModul = $id_modul ? Modul::find($id_modul) : $subject->modul->first();

        $allModulesinMapel = Modul::where('id_mapel', $id_mapel)->get();
        $completedModulesCount = 0;

        foreach($allModulesinMapel as $modul) {
    
            $totalMaterial = BahanAjar::where('id_modul', $modul->id_modul)->count();
            $completedMaterial = DB::table('bahan_ajar')
                ->join('bahan_ajar_progress', 'bahan_ajar.id_bahan_ajar', '=', 'bahan_ajar_progress.id_bahan_ajar')
                ->where('bahan_ajar.id_modul', $modul->id_modul)
                ->where('bahan_ajar_progress.id_user', $userId)
                ->where('bahan_ajar_progress.is_complete', DB::raw('true'))
                ->count();
            
            $materialClear = ($totalMaterial == $completedMaterial);
            $totalTask = Tugas::where('id_modul', $modul->id_modul)->count();
            $completedTask = Tugas::join('pengiriman_tugas','tugas.id_tugas', '=', 'pengiriman_tugas.id_tugas')
                ->where('tugas.id_modul', $modul->id_modul)
                ->where('pengiriman_tugas.id_user', $userId)
                ->where('pengiriman_tugas.status', 'dikirim')
                ->count();
            $taskClear = ($totalTask == $completedTask);

            $evaluasis = \App\Models\Evaluasi::where('id_modul', $modul->id_modul)->get();
            $totalEvaluasi = $evaluasis->count();
            $completedEvaluasi = 0;
            foreach($evaluasis as $ev) {
                if(DB::table('catatan_evaluasi')->where('id_user', $userId)->where('id_mapel', $id_mapel)->where('nama_evaluasi', $ev->judul)->exists()) {
                    $completedEvaluasi++;
                }
            }
            $evaluasiClear = ($totalEvaluasi == $completedEvaluasi);

            $totalItems = $totalMaterial + $totalTask + $totalEvaluasi;
            
            if ($totalItems == 0) {
                $completedModulesCount++;
            } elseif($materialClear && $taskClear && $evaluasiClear) {
                $completedModulesCount++;
            }
        }

        // Ambil data mapel dan announcements untuk navigasi sidebar kanan
        $subject = Mapel::with(['modul', 'announcements', 'guru'])->findOrFail($id_mapel);
        $modul_count = $subject->modul->count();
        $remainingModulesCount = max(0, $modul_count - $completedModulesCount);
        $overallProgress = $modul_count > 0 ? round(($completedModulesCount / $modul_count) * 100) : 0;

        //Function untuk menghitung progress per modul
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
                $modul->progress_percentage = 100;
            }
        }



        
        return view('students.class-detail', compact('remainingModulesCount','currentModul','subject','completedModulesCount', 'modul_count', 'overallProgress'));

    }
}
