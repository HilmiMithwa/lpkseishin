<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\Modul;
use App\Http\Requests\Teacher\StoreModulRequest;

class MapelController extends Controller
{
    public function show($id_mapel)
    {
        $classData = Mapel::with('batch')->findOrFail($id_mapel);
        $modules = Modul::where('id_mapel', $id_mapel)->get();

        return view('teacher.class-detail', compact('classData', 'modules'));
    }

    public function addModul(StoreModulRequest $request) {
        $data = $request->validated();

        // 1. Pemetaan Nama Field (Form Request: teori/praktik -> DB: jp_teori/jp_praktik)
        $data['jp_teori'] = $data['teori'] ?? null;
        $data['jp_praktik'] = $data['praktik'] ?? null;

        // Hapus key lama agar tidak mengotori array payload
        unset($data['teori'], $data['praktik']);

        // Jika teori dan praktik tidak diisi, gunakan fallback jp (dibagi 1/3 teori dan 2/3 praktik)
        if (is_null($data['jp_teori']) && is_null($data['jp_praktik'])) {
            $total_jp = $data['jp'] ?? 0;
            $data['jp_teori'] = (int) ceil($total_jp / 3);
            $data['jp_praktik'] = $total_jp - $data['jp_teori'];
        } else {
            $data['jp_teori'] = $data['jp_teori'] ?? 0;
            $data['jp_praktik'] = $data['jp_praktik'] ?? 0;
        }

        // 2. Generate kode_modul secara otomatis jika kosong
        if (empty($data['kode_modul'])) {
            $mapel = Mapel::findOrFail($data['id_mapel']);
            $level = 'MOD';
            if (preg_match('/N[3-5]/i', $mapel->target, $matches)) {
                $level = strtoupper($matches[0]);
            } elseif (preg_match('/N[3-5]/i', $mapel->nama_mapel, $matches)) {
                $level = strtoupper($matches[0]);
            }

            $count = Modul::where('id_mapel', $data['id_mapel'])->count();
            do {
                $count++;
                $kode_modul = 'MDL-' . $level . '-' . str_pad($count, 2, '0', STR_PAD_LEFT);
            } while (Modul::where('kode_modul', $kode_modul)->exists());
            $data['kode_modul'] = $kode_modul;
        }

        // 3. Simpan ke database
        Modul::create($data);

        // 4. Redirect ke detail kelas (subjects.show)
        return redirect()->route('teacher.subjects.show', $data['id_mapel'])
            ->with('success', 'Modul berhasil ditambahkan');
    }
}
