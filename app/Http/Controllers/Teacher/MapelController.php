<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\Modul;

class MapelController extends Controller
{
    /**
     * Display the class (mapel) detail page for the teacher.
     */
    public function show($id_mapel)
    {
        // Fetch the subject with its batch, modules, and announcements
        $subject = Mapel::with(['batch', 'modul', 'announcements'])->findOrFail($id_mapel);

        // Map subject data to the format expected by the view
        $classData = (object)[
            'id_mapel'              => $subject->id_mapel,
            'nama_mapel'            => $subject->nama_mapel,
            'deskripsi'             => $subject->deskripsi_mapel ?? '',
            'batch'                 => $subject->batch,
            'certification_target'  => $subject->target ?? '-',
            'total_duration'        => ($subject->jp ?? 0) . ' JP',
            'schedule'              => $subject->jadwal ?? '-',
            'pass_requirement'      => 'Min. Skor ' . ($subject->min_score ?? 0),
        ];

        // Map modules to the format expected by the view
        $modules = $subject->modul->map(function ($modul) {
            return (object)[
                'id_modul'    => $modul->id_modul,
                'nama_modul'  => $modul->nama_modul,
                'kode_modul'  => $modul->kode_modul ?? '',
                'teori_jp'    => $modul->jp_teori ?? 0,
                'praktik_jp'  => $modul->jp_praktik ?? 0,
                'note'        => $modul->module_description ?? '',
            ];
        });

        // Get announcements (as simple strings array)
        $announcements = $subject->announcements->pluck('title')->toArray();
        if (empty($announcements)) {
            $announcements = ['Belum ada pengumuman.'];
        }

        return view('teacher.class-detail', compact('classData', 'modules', 'announcements'));
    }

    /**
     * Store a new module for a subject.
     */
    public function addModul(Request $request)
    {
        $request->validate([
            'id_mapel'    => 'required|exists:mapel,id_mapel',
            'nama_modul'  => 'required|string|max:255',
            'jp_teori'    => 'nullable|integer|min:0',
            'jp_praktik'  => 'nullable|integer|min:0',
            'module_description' => 'nullable|string',
        ]);

        Modul::create([
            'id_mapel'           => $request->id_mapel,
            'nama_modul'         => $request->nama_modul,
            'jp_teori'           => $request->jp_teori ?? 0,
            'jp_praktik'         => $request->jp_praktik ?? 0,
            'module_description' => $request->module_description ?? '',
        ]);

        return redirect()->back()->with('success', 'Modul berhasil ditambahkan!');
    }
}
