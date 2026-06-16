<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectType;
use Illuminate\Support\Facades\Auth;

class ProjectTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-project-type')) {
            $projectTypes = ProjectType::paginate(10);
            return view('crm.fields.project-types.index', compact('projectTypes'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-project-type')) {
            return view('crm.fields.project-types.create');
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
            'name' => 'required|unique:project_types',
        ]);

        ProjectType::create([
            'name' => $request->name,
        ]);

        notify()->success('Project Type has been created');
        return redirect()->route('project-types.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectType $projectType)
    {
        if (Auth::user()->hasPermission('read-project-type')) {
            return view('crm.fields.project-types.show', compact('projectTypes'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectType $projectType)
    {
        if (Auth::user()->hasPermission('update-project-type')) {
            return view('crm.fields.project-types.edit', compact('projectType'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectType $projectType)
    {
        $request->validate([
            'name' => 'required|unique:project_types,name,' . $projectType->id,
        ]);

        $projectType->update($request->all());

        notify()->success('Project Type Updated');
        return redirect()->route('project-types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectType $projectType)
    {
        if (Auth::user()->hasPermission('delete-project-type')) {
            $projectType->delete();
            notify()->success('Project Type Deleted');
            return redirect()->route('project-types.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
