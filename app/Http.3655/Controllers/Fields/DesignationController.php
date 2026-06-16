<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-designation')) {
            $designations = Designation::paginate(10);
            return view('crm.fields.designations.index', compact('designations'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-designation')) {
            return view('crm.fields.designations.create');
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
            'name' => 'required|unique:designations',
        ]);

        Designation::create([
            'name' => $request->name,
        ]);

        notify()->success('Designation has been created');
        return redirect()->route('designations.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Designation $designation)
    {
        if (Auth::user()->hasPermission('read-designation')) {
            return view('crm.fields.designations.show', compact('designation'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Designation $designation)
    {
        if (Auth::user()->hasPermission('update-designation')) {
            return view('crm.fields.designations.edit', compact('designation'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Designation $designation)
    {
        $request->validate([
            'name' => 'required|unique:designations,name,' . $designation->id,
        ]);

        $designation->update($request->all());

        notify()->success('Designation Updated');
        return redirect()->route('designations.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Designation $designation)
    {
        if (Auth::user()->hasPermission('delete-designation')) {
            $designation->delete();
            notify()->success('Designation Deleted');
            return redirect()->route('designations.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
