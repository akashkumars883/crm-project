<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use App\Models\ActivityType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-activity-type')) {
            $activityTypes = ActivityType::paginate(10);
            return view('crm.fields.activity-types.index', compact('activityTypes'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-activity-type')) {
            return view('crm.fields.activity-types.create');
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
            'name' => 'required|unique:activity_types',
        ]);

        ActivityType::create([
            'name' => $request->name,
        ]);

        notify()->success('Activity Type has been created');
        return redirect()->route('activity-types.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ActivityType $activityType)
    {
        if (Auth::user()->hasPermission('read-activity-type')) {
            return view('crm.fields.activity-types.show', compact('activityType'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActivityType $activityType)
    {
        if (Auth::user()->hasPermission('update-activity-type')) {
            return view('crm.fields.activity-types.edit', compact('activityType'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActivityType $activityType)
    {
        $request->validate([
            'name' => 'required|unique:activity_types,name,' . $activityType->id,
        ]);

        $activityType->update($request->all());

        notify()->success('Activity Type Updated');
        return redirect()->route('activity-types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityType $activityType)
    {
        if (Auth::user()->hasPermission('delete-activity-type')) {
            $activityType->delete();
            notify()->success('Activity Type Deleted');
            return redirect()->route('activity-types.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
