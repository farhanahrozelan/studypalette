<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Calculate data for the Notes Overview section
        $approvedNotes = Note::where('status', 'approved')->count();
        $disapprovedNotes = Note::where('status', 'disapproved')->count();
        $reportedNotes = Note::where('status', 'reported')->count();

        // Pass the data to the view
        return view('adminDashboard', [
            'approvedNotes' => $approvedNotes,
            'disapprovedNotes' => $disapprovedNotes,
            'reportedNotes' => $reportedNotes,
        ]);
    }

}
