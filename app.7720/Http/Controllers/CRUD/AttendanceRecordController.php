<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\AttendanceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Models\AttendanceRecord;
use App\Models\AttendanceStatus;
use App\Models\Employee;
use App\Models\Project;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class AttendanceRecordController extends Controller
{
    protected $previousUrl;

    public function __construct()
    {
        $this->previousUrl = URL::previous();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::user()->hasPermission('manage-attendance-record')) {
            $chart_options = [
                'chart_title' => 'Attendance by day',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\AttendanceRecord',
                'group_by_field' => 'created_at',
                'group_by_period' => 'day',
                'date_format' => 'D',
                'chart_type' => 'bar',
            ];

            $chart1 = new LaravelChart($chart_options);

            $chart_options = [
                'chart_title' => 'Attendance by Type',
                'report_type' => 'group_by_relationship',
                'model' => 'App\Models\AttendanceRecord',
                'relationship_name' => 'attendanceType',
                'group_by_field' => 'name',
                'chart_type' => 'bar',
            ];

            $chart2 = new LaravelChart($chart_options);

            $chart_options = [
                'chart_title' => 'Activities by Status',
                'report_type' => 'group_by_relationship',
                'model' => 'App\Models\AttendanceRecord',
                'relationship_name' => 'attendanceStatus',
                'group_by_field' => 'name',
                'chart_type' => 'bar',
            ];

            $chart3 = new LaravelChart($chart_options);

            $attendanceRecords = AttendanceRecord::with(['employee', 'project', 'attendanceType', 'attendanceStatus']);

            if ($request->filled('employee_id')) {
                $attendanceRecords->whereIn('employee_id', $request->input('employee_id'));
            }

            if ($request->filled('project_id')) {
                $attendanceRecords->whereIn('project_id', $request->input('project_id'));
            }

            if ($request->filled('date')) {
                $attendanceRecords->whereDate('date', $request->input('date'));
            }

            if ($request->filled('attendance_type_id')) {
                $attendanceRecords->where('attendance_type_id', $request->input('attendance_type_id'));
            }

            if ($request->filled('attendance_status_id')) {
                $attendanceRecords->where('attendance_status_id', $request->input('attendance_status_id'));
            }

            $attendanceRecords = $attendanceRecords->paginate(10);

            $employees = Employee::all();
            $projects = Project::all();
            $attendanceStatuses = AttendanceStatus::all();
            $attendanceTypes = AttendanceType::all();

            return view('crm.crud.attendance-records.index', compact('attendanceRecords', 'chart1', 'chart2', 'chart3', 'employees', 'projects', 'attendanceTypes', 'attendanceStatuses'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-attendance-record')) {
            $employees = Employee::all();
            $projects = Project::all();
            $attendanceStatuses = AttendanceStatus::all();
            $attendanceTypes = AttendanceType::all();
            return view('crm.crud.attendance-records.create', compact('employees', 'projects', 'attendanceTypes', 'attendanceStatuses'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required|array',
            'employee_id.*' => 'exists:employees,id',
            'project_id' => 'required|array',
            'project_id.*' => 'exists:projects,id',
            'date' => 'required|date',
            'attendance_status_id' => 'required|exists:attendance_statuses,id',
            'attendance_type_id' => 'required|exists:attendance_types,id',
        ]);

        $successCount = 0;
        $duplicateCount = 0;

        foreach ($validatedData['employee_id'] as $employeeId) {
            foreach ($validatedData['project_id'] as $projectId) {
                // Check if the entry already exists
                if (!AttendanceRecord::where([
                    'employee_id' => $employeeId,
                    'project_id' => $projectId,
                    'date' => $validatedData['date'],
                ])->exists()) {
                    AttendanceRecord::create([
                        'employee_id' => $employeeId,
                        'project_id' => $projectId,
                        'date' => $validatedData['date'],
                        'attendance_type_id' => $validatedData['attendance_type_id'],
                        'attendance_status_id' => $validatedData['attendance_status_id'],
                    ]);
                    $successCount++;
                } else {
                    $duplicateCount++;
                }
            }
        }

        $message = $successCount > 0 ? "Attendance records created successfully ($successCount created)." : "No new attendance records created.";

        if ($duplicateCount > 0) {
            $message .= " $duplicateCount duplicate entries skipped.";
        }
        notify()->success($message);
        return redirect($this->previousUrl);
    }

    /**
     * Display the specified resource.
     */
    public function show(AttendanceRecord $attendanceRecord)
    {
        if (Auth::user()->hasPermission('read-attendance-record')) {
            # code...
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttendanceRecord $attendanceRecord)
    {
        if (Auth::user()->hasPermission('update-attendance-record')) {
            $attendanceRecord->load(['employee', 'project']);
            $employees = Employee::all();
            $projects = Project::all();
            $attendanceTypes = AttendanceType::all();
            $attendanceStatuses = AttendanceStatus::all();
            return view('crm.crud.attendance-records.edit', compact('attendanceRecord', 'employees', 'projects', 'attendanceTypes', 'attendanceStatuses'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AttendanceRecord $attendanceRecord)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'project_id' => 'required|exists:projects,id',
            'date' => 'required|date',
            'attendance_type_id' => 'required|exists:attendance_types,id',
            'attendance_status_id' => 'required|exists:attendance_statuses,id',
        ]);

        // Check if the entry already exists, excluding the current attendance record
        if (!AttendanceRecord::where([
            'employee_id' => $validatedData['employee_id'],
            'project_id' => $validatedData['project_id'],
            'date' => $validatedData['date'],
        ])->where('id', '<>', $attendanceRecord->id)->exists()) {
            // Update the attendance record
            $attendanceRecord->update([
                'employee_id' => $validatedData['employee_id'],
                'project_id' => $validatedData['project_id'],
                'date' => $validatedData['date'],
                'attendance_type_id' => $validatedData['attendance_type_id'],
                'attendance_status_id' => $validatedData['attendance_status_id'],
            ]);
            $message = "Attendance record updated successfully.";
        } else {
            $message = "Duplicate entry detected. No changes made to the attendance record.";
        }
        notify()->success($message);
        return redirect($this->previousUrl);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttendanceRecord $attendanceRecord)
    {
        if (Auth::user()->hasPermission('delete-attendance-record')) {
            $attendanceRecord->delete();
            notify()->success('Attendance Record Deleted');
            return redirect($this->previousUrl);
        } else {
            abort(403, 'Unauthorized Access');
        }
    }
}
