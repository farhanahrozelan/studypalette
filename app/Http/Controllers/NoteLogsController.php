<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class NoteLogsController extends Controller
{
    public function approvedNotes()
    {
        // Fetch notes with 'approved' status
        $approvedNotes = Note::where('status', 'approved')->with('creator')->get();
        
        return view('approvedNotes', compact('approvedNotes'));
    }

    public function disapprovedNotes()
    {
        // Fetch notes with 'disapproved' status
        $disapprovedNotes = Note::where('status', 'disapproved')->with('creator')->get();
        
        return view('disapprovedNotes', compact('disapprovedNotes'));
    }
}
