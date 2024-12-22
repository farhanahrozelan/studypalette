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

        return redirect()->back()->with('success', 'The note has been reported.');
    }

    

    
}
