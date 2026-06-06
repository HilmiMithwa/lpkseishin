<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\Modul;
use App\Models\BahanAjar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



//Nunggu dashboard guru kelar
class BahanAjarController extends Controller
{
    public function showMaterial($id_mapel, $id_modul, $id_materi)
    {
        // 1. Ambil data induk untuk kebutuhan Breadcrumbs & Navigasi Sidebar
        $subject = Mapel::find($id_mapel);
        $currentModul = Modul::find($id_modul);

        try {
            $material= BahanAjar::find($id_materi);
             $material->is_complete = DB::table('bahan_ajar_progress')
            ->where('id_user', auth()->id())
            ->where('id_bahan_ajar', $id_materi)
            ->value('is_complete') ?? 0;
        } catch (\Throwable $e) {
            $material = null;
        }
        
        // 2. Cari data materi di database (mengembalikan null jika tidak ada, agar ditangani Blade)
        
        
        // Inisialisasi default URL pagination
        $previousMaterialUrl = null;
        $nextMaterialUrl = null;

        if ($material) {
            // Cari materi SEBELUMNYA yang mutlak berada di dalam id_modul yang sama
            $previousMaterial = BahanAjar::where('id_modul', $id_modul)
                ->where('id_bahan_ajar', '<', $material->id_bahan_ajar)
                ->orderBy('id_bahan_ajar', 'desc')
                ->first();

            // Cari materi SELANJUTNYA yang mutlak berada di dalam id_modul yang sama
            $nextMaterial = BahanAjar::where('id_modul', $id_modul)
                ->where('id_bahan_ajar', '>', $material->id_bahan_ajar)
                ->orderBy('id_bahan_ajar', 'asc')
                ->first();

            // Susun rute URL jika record materi pendukungnya ditemukan
            $previousMaterialUrl = $previousMaterial
                ? route('materials.show', ['id_mapel' => $id_mapel, 'id_modul' => $id_modul, 'id_materi' => $previousMaterial->id_bahan_ajar])
                : null;

            $nextMaterialUrl = $nextMaterial
                ? route('materials.show', ['id_mapel' => $id_mapel, 'id_modul' => $id_modul, 'id_materi' => $nextMaterial->id_bahan_ajar])
                : null;
        }

        // 4. Kirim data ke View
        return view('students.material-detail', compact(
            'subject',
            'currentModul',
            'material',
            'previousMaterialUrl',
            'nextMaterialUrl'
        ));
    }

    public function completeMaterial($id_materi)
    {
        try {
            $userId = Auth::id();
            DB::table('bahan_ajar_progress')->updateOrInsert(
                [
                    'id_user' => $userId,
                    'id_bahan_ajar' => $id_materi
                ],
                [
                    'is_complete' => true,
                    'updated_at' => now()
                ]
            );
        } catch (\Exception $e) {

        }

        // 3. Kembalikan siswa ke halaman materi semula dengan data yang sudah terupdate
        return back();
    }
    public function downloadMaterial($id_materi)
    {
        $material = BahanAjar::findOrFail($id_materi);
        
        if (!$material->path_file_dokumen_ajar) {
            abort(404, 'File materi tidak ditemukan.');
        }

        // Remove '/storage/' prefix because the file is actually in 'storage/app/public'
        // which corresponds to the 'public' disk root.
        $path = str_replace('/storage/', '', $material->path_file_dokumen_ajar);

        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            abort(404, 'File tidak ditemukan di server.');
        }

        $fileName = $material->nama_dokumen_ajar ?? basename($path);
        
        return \Illuminate\Support\Facades\Storage::disk('public')->download($path, $fileName);
    }
}
