<?php
namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request, $noteId)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $note = Note::findOrFail($noteId);

        // Create a report
        Report::create([
            'note_id' => $note->id,
            'user_id' => auth()->id(),
            'reason' => $request->reason,
        ]);

        // Update the status of the note to 'reported' in the notes table
        $note->status = 'reported';
        $note->save();

        return redirect()->back()->with('success', 'The note has been reported.');
    }

    public function index() 
    { 
        $reportedNotes = Report::with('note', 'user')->where('status', 'reported')->get(); 
        return view('reportedNotes', compact('reportedNotes')); 
    } 
     
    public function review($noteId, $action) 
    { 
        $reportedNote = Report::where('note_id', $noteId)->first(); 
        if (!$reportedNote) { 
            return response()->json(['success' => false, 'message' => 'Note not found.']); 
        } 
         
        if ($action === 'approve') { 
            $reportedNote->status = 'approved'; 
            $reportedNote->save(); 
            Note::where('id', $noteId)->update(['status' => 'approved']); 
        } elseif ($action === 'disapprove') { 
            $reportedNote->status = 'disapproved'; 
            $reportedNote->save();

            // Update note status and set is_shared to false
            Note::where('id', $noteId)->update([
                'status' => 'disapproved',
                'is_shared' => false
            ]);

        } 
         
        return response()->json(['success' => true, 'message' => "Note {$action}d successfully."]); 
    }

    

    
}
