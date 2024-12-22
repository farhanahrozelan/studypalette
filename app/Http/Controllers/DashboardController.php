<?php
namespace App\Http\Controllers;

use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch tasks for the dashboard
        $incompleteTasks = Task::where('is_done', false)->take(3)->get();
        $completedTasks = Task::where('is_done', true)->take(3)->get();

        return view('dashboard', compact('incompleteTasks', 'completedTasks'));
    }
}
