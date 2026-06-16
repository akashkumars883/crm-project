<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use App\Models\AttendanceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-attendance-type')) {
            $attendanceTypes = AttendanceType::paginate(10);
            return view('crm.fields.attendance-types.index', compact('attendanceTypes'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-attendance-type')) {
            return view('crm.fields.attendance-types.create');
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
            'name' => 'required|unique:attendance_types',
        ]);

        AttendanceType::create([
            'name' => $request->name,
        ]);

        notify()->success('Attendance Type has been created');
        return redirect()->route('attendance-types.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(AttendanceType $attendanceType)
    {
        if (Auth::user()->hasPermission('read-attendance-type')) {
            return view('crm.fields.attendance-types.show', compact('attendanceType'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttendanceType $attendanceType)
    {
        if (Auth::user()->hasPermission('update-attendance-type')) {
            return view('crm.fields.attendance-types.edit', compact('attendanceType'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AttendanceType $attendanceType)
    {
        $request->validate([
            'name' => 'required|unique:attendance_types,name,' . $attendanceType->id,
        ]);

        $attendanceType->update($request->all());

        notify()->success('Attendance Type Updated');
        return redirect()->route('attendance-types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttendanceType $attendanceType)
    {
        if (Auth::user()->hasPermission('delete-attendance-type')) {
            $attendanceType->delete();
            notify()->success('Attendance Type Deleted');
            return redirect()->route('attendance-types.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
