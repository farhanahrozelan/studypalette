<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    // Fetch limited tasks for the dashboard
public function getDashboardTasks()
{
    $tasks = Task::where('user_id', auth()->id())
                ->where('is_done', false)
                ->latest()
                ->take(4)
                ->get();

    return view('dashboard', compact('tasks'));
}

    // Display tasks for task management
    public function index()
    {
        $tasks = Task::where('user_id', auth()->id())->get();
        return view('tasks.index', compact('tasks'));
    }

    // Store a new task
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Task::create([
            'title' => $request->title,
            'is_done' => false,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task added successfully!');
    }

    // Update a task
    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $task->update(['is_done' => $request->has('is_done')]);

        return back();
    }

    // Delete a task
    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    
        $task->delete();
    
        // Flash a success message to the session
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }
    
}
