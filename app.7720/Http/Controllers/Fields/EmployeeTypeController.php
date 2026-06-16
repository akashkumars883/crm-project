<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeType;
use Illuminate\Support\Facades\Auth;

class EmployeeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-employee-type')) {
            $employeeTypes = EmployeeType::paginate(10);
            return view('crm.fields.employee-types.index', compact('employeeTypes'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-employee-type')) {
            return view('crm.fields.employee-types.create');
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
            'name' => 'required|unique:employee_types',
        ]);

        EmployeeType::create([
            'name' => $request->name,
        ]);

        notify()->success('Employee Type has been created');
        return redirect()->route('employee-types.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeType $employeeType)
    {
        if (Auth::user()->hasPermission('read-employee-type')) {
            return view('crm.fields.employee-types.show', compact('employeeType'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeType $employeeType)
    {
        if (Auth::user()->hasPermission('update-employee-type')) {
            return view('crm.fields.employee-types.edit', compact('employeeType'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeType $employeeType)
    {
        $request->validate([
            'name' => 'required|unique:employee_types,name,' . $employeeType->id,
        ]);

        $employeeType->update($request->all());

        notify()->success('Employee Type Updated');
        return redirect()->route('employee-types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeType $employeeType)
    {
        if (Auth::user()->hasPermission('delete-employee-type')) {
            $employeeType->delete();
            notify()->success('Employee Type Deleted');
            return redirect()->route('employee-types.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
