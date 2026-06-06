<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Modul;
use App\Models\Evaluasi;
use App\Models\EvaluasiQuestion;
use App\Models\EvaluasiQuestionImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EvaluasiController extends Controller
{
    public function create($id_modul)
    {
        return view('teacher.evaluation-create', ['currentModuleId' => $id_modul]);
    }

    public function store(Request $request, $id_modul)
    {
        // Start database transaction to ensure atomicity
        DB::beginTransaction();

        try {
            // 1. Create Evaluasi record
            $evaluasi = Evaluasi::create([
                'id_modul' => $id_modul,
                'judul' => $request->input('judul'),
                'bahasa' => $request->input('bahasa'),
                'durasi_menit' => $request->input('durasi_menit'),
                'tipe' => $request->input('tipe'),
                'panduan' => json_decode($request->input('panduan', '[]'), true),
            ]);

            // 2. Handle Multiple Choice Questions
            if ($request->input('tipe') !== 'Essay Only') {
                $mcqsStr = $request->input('mcqs');
                if ($mcqsStr) {
                    $mcqs = json_decode($mcqsStr, true);
                    if (is_array($mcqs)) {
                        foreach ($mcqs as $index => $mcqData) {
                            if (empty(trim($mcqData['question'] ?? ''))) continue;

                            $question = EvaluasiQuestion::create([
                                'id_evaluasi' => $evaluasi->id_evaluasi,
                                'tipe_soal' => 'mcq',
                                'pertanyaan' => trim($mcqData['question']),
                                'pilihan' => $mcqData['options'] ?? [],
                                'kunci_jawaban' => $mcqData['correct_answer'] ?? null
                            ]);

                            // Handle MCQ Images
                            if ($request->hasFile("mcq_images.{$index}")) {
                                foreach ($request->file("mcq_images.{$index}") as $file) {
                                    $path = $file->store('evaluasi_images', 'public');
                                    EvaluasiQuestionImage::create([
                                        'id_soal' => $question->id_soal,
                                        'image_path' => $path
                                    ]);
                                }
                            }
                        }
                    }
                }
            }

            // 3. Handle Essay Questions
            if ($request->input('tipe') !== 'Multiple Choice Only') {
                $essaysStr = $request->input('essays');
                if ($essaysStr) {
                    $essays = json_decode($essaysStr, true);
                    if (is_array($essays)) {
                        foreach ($essays as $index => $essayData) {
                            if (empty(trim($essayData['question'] ?? ''))) continue;

                            $question = EvaluasiQuestion::create([
                                'id_evaluasi' => $evaluasi->id_evaluasi,
                                'tipe_soal' => 'essay',
                                'pertanyaan' => trim($essayData['question'])
                            ]);

                            // Handle Essay Images
                            if ($request->hasFile("essay_images.{$index}")) {
                                foreach ($request->file("essay_images.{$index}") as $file) {
                                    $path = $file->store('evaluasi_images', 'public');
                                    EvaluasiQuestionImage::create([
                                        'id_soal' => $question->id_soal,
                                        'image_path' => $path
                                    ]);
                                }
                            }
                        }
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Evaluasi berhasil ditambahkan!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id_modul, $id)
    {
        $evaluasi = Evaluasi::with(['modul.mapel.batch', 'questions.images'])->findOrFail($id);
        
        return view('teacher.evaluation-show', compact('evaluasi', 'id_modul'));
    }

    public function destroy($id_modul, $id)
    {
        $evaluasi = Evaluasi::findOrFail($id);

        foreach ($evaluasi->questions as $question) {
            foreach ($question->images as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
            }
            $question->images()->delete();
            $question->delete();
        }
        $evaluasi->delete();

        return redirect()->route('teacher.modules.show', $id_modul)->with('success', 'Evaluasi berhasil dihapus!');
    }
}
