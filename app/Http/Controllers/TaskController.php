<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Notifications\SystemAlert;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('company_id', Auth::user()->company_id)->latest()->paginate(10);
        return view('crm.crud.tasks.index', compact('tasks'));
    }

    public function create()
    {
        $users = User::where('company_id', Auth::user()->company_id)->get();
        return view('crm.crud.tasks.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);
        
        $validated['company_id'] = Auth::user()->company_id;

        $task = Task::create($validated);

        if ($task->assigned_to && $task->assigned_to != Auth::id()) {
            $assignee = User::find($task->assigned_to);
            if ($assignee) {
                $assignee->notify(new SystemAlert('New Task Assigned', "You have been assigned to task: {$task->title}", 'clipboard-list', 'primary'));
            }
        }

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        $users = User::where('company_id', Auth::user()->company_id)->get();
        return view('crm.crud.tasks.edit', compact('task', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $oldAssignee = $task->assigned_to;
        $task->update($validated);

        if ($task->assigned_to && $task->assigned_to != $oldAssignee && $task->assigned_to != Auth::id()) {
            $assignee = User::find($task->assigned_to);
            if ($assignee) {
                $assignee->notify(new SystemAlert('New Task Assigned', "You have been assigned to task: {$task->title}", 'clipboard-list', 'info'));
            }
        }

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
