<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-department')) {
            $departments = Department::paginate(10);
            return view('crm.fields.departments.index', compact('departments'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-department')) {
            return view('crm.fields.departments.create');
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
            'name' => 'required|unique:departments',
        ]);

        Department::create([
            'name' => $request->name,
        ]);

        notify()->success('Department has been created');
        return redirect()->route('departments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        if (Auth::user()->hasPermission('read-department')) {
            return view('crm.fields.departments.show', compact('department'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        if (Auth::user()->hasPermission('update-department')) {
            return view('crm.fields.departments.edit', compact('department'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|unique:departments,name,' . $department->id,
        ]);

        $department->update($request->all());

        notify()->success('Department Updated');
        return redirect()->route('departments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        if (Auth::user()->hasPermission('delete-department')) {
            $department->delete();
            notify()->success('Department Deleted');
            return redirect()->route('departments.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
