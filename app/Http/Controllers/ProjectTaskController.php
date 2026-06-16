<?php

namespace App\Http\Controllers;

use App\Models\ProjectTask;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:To Do,In Progress,Done',
            'assignee_id' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
        ]);

        ProjectTask::create($request->all());

        notify()->success('Task created successfully');
        return redirect()->back();
    }

    public function update(Request $request, ProjectTask $projectTask)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:To Do,In Progress,Done',
            'assignee_id' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
        ]);

        $projectTask->update($request->all());

        notify()->success('Task updated successfully');
        return redirect()->back();
    }

    public function updateStatus(Request $request, ProjectTask $projectTask)
    {
        $request->validate([
            'status' => 'required|in:To Do,In Progress,Done',
        ]);

        $projectTask->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }

    public function destroy(ProjectTask $projectTask)
    {
        $projectTask->delete();
        notify()->success('Task deleted successfully');
        return redirect()->back();
    }
}
