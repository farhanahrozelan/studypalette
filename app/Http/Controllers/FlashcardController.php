<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use App\Models\FlashcardSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlashcardController extends Controller
{
    // Display the list of flashcard sets for the authenticated user
    public function index()
    {
        $flashcardSets = FlashcardSet::where('user_id', Auth::id())->with('flashcards')->get();
        return view('flashcards.index', compact('flashcardSets'));
    }

    // Display the form to create a new flashcard set
    public function create()
    {
        return view('flashcards.create');
    }

    // Store a newly created flashcard set with flashcards for the authenticated user
    public function store(Request $request)
    {
        $request->validate([
            'set_name' => 'required|string|max:255',
            'questions' => 'required|array',
            'answers' => 'required|array',
            'questions.*' => 'required|string',
            'answers.*' => 'required|string',
        ]);

        // Create the flashcard set
        $flashcardSet = FlashcardSet::create([
            'name' => $request->set_name,
            'user_id' => Auth::id(),
        ]);

        // Create flashcards associated with the set
        foreach ($request->questions as $index => $question) {
            Flashcard::create([
                'flashcard_set_id' => $flashcardSet->id,
                'question' => $question,
                'answer' => $request->answers[$index],
            ]);
        }

        return redirect()->route('flashcards.index')->with('success', 'Flashcards created successfully!');
    }

    // Show a specific flashcard set and its flashcards for the authenticated user
    public function show($id)
    {
        $flashcardSet = FlashcardSet::where('user_id', Auth::id())->with('flashcards')->findOrFail($id);
        return view('flashcards.show', compact('flashcardSet'));
    }

    // Display form to add a flashcard to an existing set
    public function add($flashcardSetId)
    {
        $flashcardSet = FlashcardSet::where('user_id', Auth::id())->findOrFail($flashcardSetId);
        return view('flashcards.add', compact('flashcardSet'));
    }

    // Store a new flashcard in an existing set
    public function storeFlashcard(Request $request, $flashcardSetId)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        $flashcardSet = FlashcardSet::where('user_id', Auth::id())->findOrFail($flashcardSetId);

        Flashcard::create([
            'flashcard_set_id' => $flashcardSet->id,
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return redirect()->route('flashcards.show', $flashcardSet->id)
                         ->with('success', 'Flashcard added successfully!');
    }

    // Edit a flashcard set for the authenticated user
    public function edit($id)
    {
        $flashcardSet = FlashcardSet::where('user_id', Auth::id())->with('flashcards')->findOrFail($id);
        return view('flashcards.edit', compact('flashcardSet'));
    }

    // Update a flashcard set for the authenticated user
    public function update(Request $request, $id)
    {
        $request->validate([
            'set_name' => 'required|string|max:255',
            'flashcards' => 'required|array',
            'flashcards.*.id' => 'nullable|integer|exists:flashcards,id',
            'flashcards.*.question' => 'required|string',
            'flashcards.*.answer' => 'required|string',
        ]);

        $flashcardSet = FlashcardSet::where('user_id', Auth::id())->findOrFail($id);
        $flashcardSet->name = $request->set_name;
        $flashcardSet->save();

        foreach ($request->flashcards as $flashcardData) {
            if (!empty($flashcardData['id'])) {
                $flashcard = Flashcard::findOrFail($flashcardData['id']);
                $flashcard->update([
                    'question' => $flashcardData['question'],
                    'answer' => $flashcardData['answer'],
                ]);
            } else {
                $flashcardSet->flashcards()->create([
                    'question' => $flashcardData['question'],
                    'answer' => $flashcardData['answer'],
                ]);
            }
        }

        return redirect()->route('flashcards.index')->with('success', 'Flashcard set and flashcards updated successfully!');
    }

    // Delete a flashcard set and its flashcards for the authenticated user
    public function destroy($id)
    {
        $flashcardSet = FlashcardSet::where('user_id', Auth::id())->findOrFail($id);
        $flashcardSet->delete();

        return redirect()->route('flashcards.index')->with('success', 'Flashcard set deleted successfully!');
    }
}
