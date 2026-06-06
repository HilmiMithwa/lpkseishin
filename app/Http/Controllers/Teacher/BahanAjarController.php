<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Teacher\BahanAjarStoreRequest;
use App\Models\BahanAjar;
use App\Models\Modul;
use Illuminate\Support\Facades\Storage;

class BahanAjarController extends Controller
{
    public function show($id_modul, $id_materi)
    {
        $material = BahanAjar::findOrFail($id_materi);
        $module = Modul::with(['mapel', 'mapel.batch'])->findOrFail($id_modul);

        return view('teacher.material-detail', [
            'material' => $material,
            'currentModuleId' => $id_modul,
            'module' => $module,
        ]);
    }

    public function store(BahanAjarStoreRequest $request, $id_modul)
    {
        $validatedData = $request->validated();
        $validatedData['id_modul'] = $id_modul;
        
        if (isset($validatedData['type'])) {
            $validatedData['type'] = strtolower($validatedData['type']);
        } else {
            $validatedData['type'] = 'practice';
        }

        $bahanAjar = BahanAjar::create($validatedData);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Bahan Ajar berhasil dibuat',
                'data' => $bahanAjar
            ]);
        }

        return redirect()->route('teacher.modules.show', $id_modul)->with('success', 'Bahan Ajar berhasil dibuat');
    }

    public function destroy($id_modul, $id_materi)
    {
        $material = BahanAjar::findOrFail($id_materi);

        $disk = env('FILESYSTEM_DISK', 's3');

        if ($material->path_file_dokumen_ajar && Storage::disk($disk)->exists($material->path_file_dokumen_ajar)) {
            Storage::disk($disk)->delete($material->path_file_dokumen_ajar);
        }

        $material->delete();

        return redirect()->route('teacher.modules.show', $id_modul)->with('success', 'Materi berhasil dihapus');
    }

    
}
