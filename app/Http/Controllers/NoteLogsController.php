<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class NoteLogsController extends Controller
{
    public function approvedNotes()
    {
        // Fetch notes with 'approved' status
        $approvedNotes = Note::where('status', 'approved')->with('user')->get();
        
        return view('approvedNotes', compact('approvedNotes'));
    }

    public function disapprovedNotes()
    {
        // Fetch notes with 'disapproved' status
        $disapprovedNotes = Note::where('status', 'disapproved')->with('user')->get();
        
        return view('disapprovedNotes', compact('disapprovedNotes'));
    }

    public function view($noteId)
    {
        // Fetch the note by its ID
        $note = Note::where('id', $noteId)->first();
        
        // Check if the note exists
        if (!$note) {
            return response()->json(['success' => false, 'message' => 'Note not found.']);
        }
        
        // Return the note details as JSON
        return response()->json([
            'success' => true, 
            'note' => [
                'title' => $note->title,
                'key_points' => $note->key_points,
                'notes' => $note->notes,
                'summary' => $note->summary
            ]
        ]);
    }


}
