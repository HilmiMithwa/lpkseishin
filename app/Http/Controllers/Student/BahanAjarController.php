<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\Modul;
use App\Models\BahanAjar;
use Illuminate\Support\Facades\DB;



//Nunggu dashboard guru kelar
class BahanAjarController extends Controller
{
    public function showMaterial($id_mapel, $id_modul, $id_materi)
    {
        // 1. Ambil data induk untuk kebutuhan Breadcrumbs & Navigasi Sidebar
        $subject = Mapel::find($id_mapel);
        $currentModul = Modul::find($id_modul);

        // 2. Cari data materi di database (mengembalikan null jika tidak ada, agar ditangani Blade)
        $material = null;
        try {
            $material = BahanAjar::find($id_materi);
        } catch (\Throwable $e) {
            $material = null;
        }

        // Inisialisasi default URL pagination
        $previousMaterialUrl = null;
        $nextMaterialUrl = null;

        // 3. 🌟 LOGIKA UTAMAKAN KUNCI PAGINATION PER MODUL 🌟
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
            // 1. Cari data materi berdasarkan Primary Key aslinya
            $material = BahanAjar::find($id_materi);

            if ($material) {
                // 2. Ubah kolom is_complete menjadi 1 (true / selesai)
                $material->is_complete = 1;
                $material->save();
            }
        } catch (\Throwable $e) {
            // Jika database belum siap/error, tetap biarkan halaman melakukan refresh tanpa crash
        }

        // 3. Kembalikan siswa ke halaman materi semula dengan data yang sudah terupdate
        return back();
    }
}
