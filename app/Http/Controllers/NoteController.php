<?php
// app/Http/Controllers/NoteController.php
namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function __construct()
    {
        // Ensure that the user is authenticated for any of the following actions
        $this->middleware('auth');
    }

    public function index()
    {
        // Fetch notes that belong to the authenticated user
        $notes = Note::where('user_id', auth()->id())->get();

        // Pass notes to the view
        return view('notes.index', compact('notes'));
    }

    // Display the "Create Note" form
    public function create()
    {
        return view('notes.create');
    }

    // Store the new note in the database
    public function store(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'key_points' => 'nullable|string',
            'notes' => 'nullable|string',
            'summary' => 'nullable|string',
        ]);

        // Add the authenticated user's ID
        $validatedData['user_id'] = auth()->id(); // Ensure the user is authenticated

        // Create the note
        Note::create($validatedData);

        // Redirect to the notes index with a success message
        return redirect()->route('notes.index')->with('success', 'Note created successfully!');
    }

    public function edit(Note $note)
    {
        // Ensure the note belongs to the authenticated user
        if ($note->user_id !== auth()->id()) {
            return redirect()->route('notes.index')->with('error', 'Unauthorized access.');
        }

        return view('notes.edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        // Ensure the note belongs to the authenticated user
        if ($note->user_id !== auth()->id()) {
            return redirect()->route('notes.index')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'title' => 'required|max:255',
            'key_points' => 'nullable|string',
            'notes' => 'nullable|string',
            'summary' => 'nullable|string',
        ]);

        $note->update($request->all());

        return redirect()->route('notes.index')->with('success', 'Note updated successfully!');
    }

    public function destroy(Note $note)
    {
        // Ensure the note belongs to the authenticated user
        if ($note->user_id !== auth()->id()) {
            return redirect()->route('notes.index')->with('error', 'Unauthorized access.');
        }

        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Note deleted successfully!');
    }

    public function show($id)
    {
        $note = Note::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        return view('notes.show', compact('note'));
    }


    // Share a note
    public function share(Note $note)
    {
        if ($note->user_id !== auth()->id()) {
            return redirect()->route('notes.index')->with('error', 'Unauthorized access.');
        }

        $note->update(['is_shared' => true]);
        return redirect()->route('notes.index')->with('success', 'Note shared successfully!');
    }

    // Display all shared notes
    public function sharedNotes()
    {
        // Fetch all notes marked as shared
        $sharedNotes = Note::where('is_shared', true)->with('user')->get();
    
        return view('notes.shared', compact('sharedNotes'));
    }

    public function showSharedNote(Note $note)
{
    // Ensure the note is shared
    if (!$note->is_shared) {
        return redirect()->route('notes.shared')->with('error', 'This note is not shared.');
    }

    // Return the view with the note details
    return view('notes.show-shared', compact('note'));
}

    
}
