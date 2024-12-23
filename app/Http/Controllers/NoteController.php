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

public function storeSharedNotes(Request $request)
{
    // Validate the input
    $validatedData = $request->validate([
        'note_id' => 'required|exists:notes,id',
        'shared_with' => 'required|email',
    ]);

    // Logic to store the shared note
    SharedNote::create([
        'note_id' => $validatedData['note_id'],
        'shared_with' => $validatedData['shared_with'],
    ]);

    // Redirect or return a response
    return redirect()->route('notes.shared')->with('success', 'Note shared successfully!');
}

public function handleNoteUpload(Request $request) 
{ 
    $noteTitle = $request->input('title'); //Get the note title 
    $noteContent = $request->input('notes'); //Get the note content 
    $noteKeyPoints = $request->input('key_points'); //Get the note key points 
    $noteSummary = $request->input('summary'); //Get the note summary 
    $createdBy = $request->input('user_id'); //Get who created the note 

    //Save the note with an 'approved' status directly 
    $note = new Note(); 
    $note->title = $noteTitle; 
    $note->notes = $noteContent; 
    $note->key_points = $noteKeyPoints; 
    $note->summary = $noteSummary; 
    $note->user_id = $createdBy; 
    $note->status = 'approved'; // Automatically approve the note 
    $note->save(); 

    // Return a success response 
    return response()->json(['message' => 'Note approved successfully']); 

} 

public function updateNoteStatus(Request $request, $noteId) 
{ 
    $note = Note::find($noteId); 
     
    if (!$note) { 
        return redirect()->back()->with('error', 'Note not found.'); 
    } 
     
    // Update based on admin action 
    $action = $request->input('action'); // 'approve' or 'disapprove' 
     
    if ($action === 'approve') { 
        $note->status = 'approved';             
    } elseif ($action === 'disapprove') { 
        $note->status = 'disapproved'; 
    } 
     
    $note->save(); 
     
    return redirect()->back()->with('success', 'Note status updated successfully.'); 
}

    
}
