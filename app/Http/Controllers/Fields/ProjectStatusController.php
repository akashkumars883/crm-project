<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectStatus;
use Illuminate\Support\Facades\Auth;

class ProjectStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-project-status')) {
            $projectStatuses = ProjectStatus::paginate(10);
            return view('crm.fields.project-statuses.index', compact('projectStatuses'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-project-status')) {
            return view('crm.fields.project-statuses.create');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:project_statuses',
        ]);

        ProjectStatus::create([
            'name' => $request->name,
        ]);

        notify()->success('Project Status has been created');
        return redirect()->route('project-statuses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectStatus $projectStatus)
    {
        if (Auth::user()->hasPermission('read-project-status')) {
            return view('crm.fields.project-statuses.show', compact('projectStatus'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectStatus $projectStatus)
    {
        if (Auth::user()->hasPermission('update-project-status')) {
            return view('crm.fields.project-statuses.edit', compact('projectStatus'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectStatus $projectStatus)
    {
        $request->validate([
            'name' => 'required|unique:project_statuses,name,' . $projectStatus->id,
        ]);

        $projectStatus->update($request->all());

        notify()->success('Project Status Updated');
        return redirect()->route('project-statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectStatus $projectStatus)
    {
        if (Auth::user()->hasPermission('delete-project-status')) {
            $projectStatus->delete();
            notify()->success('Project Status Deleted');
            return redirect()->route('project-statuses.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
