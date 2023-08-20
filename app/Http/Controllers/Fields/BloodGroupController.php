<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use App\Models\BloodGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BloodGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-blood-group')) {
            $bloodGroups = BloodGroup::paginate(10);
            return view('crm.fields.blood-groups.index', compact('bloodGroups'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-blood-group')) {
            return view('crm.fields.blood-groups.create');
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
            'name' => 'required|unique:blood_groups',
        ]);

        BloodGroup::create([
            'name' => $request->name,
        ]);

        notify()->success('Blood Group has been created');
        return redirect()->route('blood-groups.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(BloodGroup $bloodGroup)
    {
        if (Auth::user()->hasPermission('read-blood-group')) {
            return view('crm.fields.blood-groups.show', compact('bloodGroup'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BloodGroup $bloodGroup)
    {
        if (Auth::user()->hasPermission('update-blood-group')) {
            return view('crm.fields.blood-groups.edit', compact('bloodGroup'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BloodGroup $bloodGroup)
    {
        $request->validate([
            'name' => 'required|unique:blood_groups,name,' . $bloodGroup->id,
        ]);

        $bloodGroup->update($request->all());

        notify()->success('Blood Group Updated');
        return redirect()->route('blood-groups.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BloodGroup $bloodGroup)
    {
        if (Auth::user()->hasPermission('delete-blood-group')) {
            $bloodGroup->delete();
            notify()->success('Blood Group Deleted');
            return redirect()->route('blood-groups.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
