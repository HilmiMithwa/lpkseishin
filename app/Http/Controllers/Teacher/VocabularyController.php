<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vocabulary;

class VocabularyController extends Controller
{
    public function store(Request $request, $level_id)
    {
        $request->validate([
            'kanji' => 'required|string|max:255',
            'furigana' => 'required|string|max:255',
            'romaji' => 'required|string|max:255',
            'meaning_id' => 'required|string|max:255',
            'context_jp' => 'required|string',
            // meaning_en and definition_id are required by db, we'll provide defaults if missing from request
        ]);

        Vocabulary::create([
            'kanji' => $request->kanji,
            'furigana' => $request->furigana,
            'romaji' => $request->romaji,
            'meaning_id' => $request->meaning_id,
            'meaning_en' => $request->meaning_en ?? '-',
            'level' => $level_id,
            'definition_id' => $request->definition_id ?? 'Tindakan untuk belajar atau mempelajari sesuatu hal baru.', // Default
            'contextual_usage' => $request->context_jp,
        ]);

        return redirect()->back()->with('success', 'Flashcard berhasil dibuat!');
    }

    public function update(Request $request, $id_vocabulary)
    {
        $vocab = Vocabulary::findOrFail($id_vocabulary);

        $request->validate([
            'kanji' => 'required|string|max:255',
            'furigana' => 'required|string|max:255',
            'romaji' => 'required|string|max:255',
            'meaning_id' => 'required|string|max:255',
            'context_jp' => 'required|string',
        ]);

        $vocab->update([
            'kanji' => $request->kanji,
            'furigana' => $request->furigana,
            'romaji' => $request->romaji,
            'meaning_id' => $request->meaning_id,
            'meaning_en' => $request->meaning_en ?? $vocab->meaning_en,
            'definition_id' => $request->definition_id ?? $vocab->definition_id,
            'contextual_usage' => $request->context_jp,
        ]);

        return redirect()->back()->with('success', 'Flashcard berhasil diperbarui!');
    }

    public function destroy($id_vocabulary)
    {
        $vocab = Vocabulary::findOrFail($id_vocabulary);
        $vocab->delete();

        return redirect()->back()->with('success', 'Flashcard berhasil dihapus!');
    }
}
