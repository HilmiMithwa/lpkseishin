<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vocabulary;

class VocabularyController extends Controller
{
    public function index()
    {
        $totalWords = Vocabulary::count();
        $dailyWord = Vocabulary::inRandomOrder()->first();
        
        $levels = \App\Models\VocabularyLevel::orderBy('level')->pluck('level');
        
        if ($levels->isEmpty()) {
            $levels = collect([1]); // Default empty state
        }
        
        $flashcardLevels = [];
        foreach ($levels as $i) {
            $lastUpdated = Vocabulary::where('level', $i)->max('updated_at');
            
            // Format updated time using Carbon's diffForHumans (e.g., "2 hours ago")
            // Make sure Carbon is using Indonesian locale by setting it, or just let it use default.
            \Carbon\Carbon::setLocale('id');
            $updatedText = $lastUpdated ? \Carbon\Carbon::parse($lastUpdated)->diffForHumans() : 'Belum ada data';
            
            $flashcardLevels[] = (object)[
                'level' => $i,
                'total' => Vocabulary::where('level', $i)->count(),
                'updated' => $updatedText
            ];
        }

        return view('teacher.vocabulary', compact('dailyWord','totalWords', 'flashcardLevels'));
    }

    public function store(Request $request, $level_id)
    {
        $request->validate([
            'kanji' => 'required|string|max:255',
            'furigana' => 'required|string|max:255',
            'romaji' => 'required|string|max:255',
            'meaning_id' => 'required|string|max:255',
            'meaning_en' => 'required|string|max:255',
            'context_jp' => 'required|string',
            // definition_id are required by db, we'll provide defaults if missing from request
        ]);

        Vocabulary::create([
            'kanji' => $request->kanji,
            'furigana' => $request->furigana,
            'romaji' => $request->romaji,
            'meaning_id' => $request->meaning_id,
            'category' => $request->category,
            'meaning_en' => $request->meaning_en,
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
            'meaning_en' => 'required|string|max:255',
            'context_jp' => 'required|string',
        ]);

        $vocab->update([
            'kanji' => $request->kanji,
            'furigana' => $request->furigana,
            'romaji' => $request->romaji,
            'meaning_id' => $request->meaning_id,
            'category' => $request->category,
            'meaning_en' => $request->meaning_en,
            'definition_id' => $request->definition_id ?? $vocab->definition_id,
            'contextual_usage' => $request->context_jp,
        ]);

        return redirect()->back()->with('success', 'Flashcard berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $vocab = Vocabulary::findOrFail($id);
        $vocab->delete();

        return redirect()->back()->with('success', 'Flashcard berhasil dihapus!');
    }

    public function storeLevel(Request $request)
    {
        $request->validate([
            'level' => 'required|integer|min:1'
        ]);

        \App\Models\VocabularyLevel::firstOrCreate(['level' => $request->level]);

        return redirect()->route('teacher.vocabulary.level', $request->level)->with('success', 'Level baru berhasil dibuat!');
    }

    public function updateLevel(Request $request, $level_id)
    {
        $request->validate([
            'new_level' => 'required|integer|min:1'
        ]);

        if ($level_id != $request->new_level) {
            $exists = \App\Models\VocabularyLevel::where('level', $request->new_level)->exists();
            
            if ($exists) {
                // Merge scenario: Move vocabularies and delete old level
                Vocabulary::where('level', $level_id)->update(['level' => $request->new_level]);
                \App\Models\VocabularyLevel::where('level', $level_id)->delete();
            } else {
                // Rename scenario: Update both
                \App\Models\VocabularyLevel::where('level', $level_id)->update(['level' => $request->new_level]);
                Vocabulary::where('level', $level_id)->update(['level' => $request->new_level]);
            }
        }

        return redirect()->back()->with('success', 'Level berhasil diperbarui!');
    }

    public function destroyLevel($level_id)
    {
        \App\Models\VocabularyLevel::where('level', $level_id)->delete();
        Vocabulary::where('level', $level_id)->delete();

        return redirect()->back()->with('success', 'Level beserta isinya berhasil dihapus!');
    }
}
