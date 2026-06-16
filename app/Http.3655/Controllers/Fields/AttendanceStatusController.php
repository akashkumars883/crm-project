<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use App\Models\AttendanceStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-attendance-status')) {
            $attendanceStatuses = AttendanceStatus::paginate(10);
            return view('crm.fields.attendance-statuses.index', compact('attendanceStatuses'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-attendance-status')) {
            return view('crm.fields.attendance-statuses.create');
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
            'name' => 'required|unique:attendance_statuses',
        ]);

        AttendanceStatus::create([
            'name' => $request->name,
        ]);

        notify()->success('Attendance status has been created');
        return redirect()->route('attendance-statuses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(AttendanceStatus $attendanceStatus)
    {
        if (Auth::user()->hasPermission('read-attendance-status')) {
            return view('crm.fields.attendance-statuses.show', compact('attendanceStatus'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttendanceStatus $attendanceStatus)
    {
        if (Auth::user()->hasPermission('update-attendance-status')) {
            return view('crm.fields.attendance-statuses.edit', compact('attendanceStatus'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AttendanceStatus $attendanceStatus)
    {
        $request->validate([
            'name' => 'required|unique:attendance_statuses,name,' . $attendanceStatus->id,
        ]);

        $attendanceStatus->update($request->all());

        notify()->success('Attendance Status Updated');
        return redirect()->route('attendance-statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttendanceStatus $attendanceStatus)
    {
        if (Auth::user()->hasPermission('delete-attendance-status')) {
            $attendanceStatus->delete();
            notify()->success('Attendance Status Deleted');
            return redirect()->route('attendance-statuses.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
