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
     * Display 1-Click Daily Attendance Matrix Sheet
     */
    /**
     * Display Unified Attendance Management Dashboard (1-Click Sheet + History Logs)
     */
    /**
     * Display Unified 1-Click Master Attendance Management Dashboard
     */
    public function sheet(Request $request)
    {
        if (Auth::user()->hasPermission('manage-attendance-record')) {
            $date = $request->input('date', now()->toDateString());
            $month = $request->input('month');
            $search = $request->input('search');
            $employeeId = $request->input('employee_id');
            $statusId = $request->input('attendance_status_id');

            $employeesQuery = Employee::with(['designation', 'department', 'employeeType']);
            if ($search) {
                $employeesQuery->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('emp_id', 'LIKE', "%{$search}%")
                      ->orWhere('phone', 'LIKE', "%{$search}%");
                });
            }
            if ($employeeId) {
                $employeesQuery->where('id', $employeeId);
            }
            $employees = $employeesQuery->orderBy('name', 'asc')->get();

            $existingRecords = AttendanceRecord::with(['attendanceStatus', 'project'])
                ->whereDate('date', $date)
                ->get()
                ->keyBy('employee_id');

            $projects = Project::all();
            $attendanceStatuses = AttendanceStatus::all();

            $presentStatus = AttendanceStatus::firstOrCreate(['name' => 'Present']);
            $halfDayStatus = AttendanceStatus::firstOrCreate(['name' => 'Half Day']);
            $absentStatus = AttendanceStatus::firstOrCreate(['name' => 'Absent']);

            $stats = [
                'total' => $employees->count(),
                'present' => 0,
                'half_day' => 0,
                'absent' => 0,
                'unmarked' => 0,
            ];

            foreach ($employees as $emp) {
                if (isset($existingRecords[$emp->id])) {
                    $stName = strtolower(optional($existingRecords[$emp->id]->attendanceStatus)->name ?? '');
                    if (str_contains($stName, 'present')) {
                        $stats['present']++;
                    } elseif (str_contains($stName, 'half')) {
                        $stats['half_day']++;
                    } elseif (str_contains($stName, 'absent') || str_contains($stName, 'leave')) {
                        $stats['absent']++;
                    } else {
                        $stats['unmarked']++;
                    }
                } else {
                    $stats['unmarked']++;
                }
            }

            return view('crm.crud.attendance-records.sheet', compact(
                'employees', 
                'existingRecords', 
                'date', 
                'month',
                'search',
                'employeeId',
                'statusId',
                'stats', 
                'projects', 
                'attendanceStatuses',
                'presentStatus', 
                'halfDayStatus', 
                'absentStatus'
            ));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * AJAX 1-Click Toggle Attendance Status
     */
    public function toggleAttendance(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'status' => 'required|string',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $employeeId = $request->input('employee_id');
        $date = $request->input('date');
        $statusKey = strtolower($request->input('status'));

        if ($statusKey === 'unmark' || $statusKey === 'clear') {
            AttendanceRecord::where('employee_id', $employeeId)->whereDate('date', $date)->delete();
            return response()->json([
                'success' => true,
                'status' => 'unmarked',
                'badge_class' => 'bg-secondary',
                'message' => 'Attendance cleared'
            ]);
        }

        $statusName = 'Present';
        $badgeClass = 'bg-success';
        if ($statusKey === 'half_day' || $statusKey === 'half') {
            $statusName = 'Half Day';
            $badgeClass = 'bg-warning';
        } elseif ($statusKey === 'absent') {
            $statusName = 'Absent';
            $badgeClass = 'bg-danger';
        }

        $statusObj = AttendanceStatus::firstOrCreate(['name' => $statusName]);
        $typeObj = AttendanceType::firstOrCreate(['name' => 'Regular']);

        $projectId = $request->input('project_id') ?: null;

        $record = AttendanceRecord::updateOrCreate(
            ['employee_id' => $employeeId, 'date' => $date],
            [
                'attendance_status_id' => $statusObj->id,
                'attendance_type_id' => $typeObj->id,
                'project_id' => $projectId,
            ]
        );

        return response()->json([
            'success' => true,
            'status' => strtolower($statusName),
            'status_name' => $statusName,
            'badge_class' => $badgeClass,
            'message' => "Marked {$statusName} for " . optional($record->employee)->name
        ]);
    }

    /**
     * Bulk Mark All Active Employees as Present for a Date
     */
    public function bulkPresent(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $presentStatus = AttendanceStatus::firstOrCreate(['name' => 'Present']);
        $typeObj = AttendanceType::firstOrCreate(['name' => 'Regular']);

        $employees = Employee::all();
        $count = 0;

        foreach ($employees as $emp) {
            $exists = AttendanceRecord::where('employee_id', $emp->id)->whereDate('date', $date)->exists();
            if (!$exists) {
                AttendanceRecord::create([
                    'employee_id' => $emp->id,
                    'date' => $date,
                    'attendance_status_id' => $presentStatus->id,
                    'attendance_type_id' => $typeObj->id,
                    'project_id' => null,
                ]);
                $count++;
            }
        }

        notify()->success("Marked {$count} employees Present for {$date}.");
        return redirect()->route('attendance-records.sheet', ['date' => $date]);
    }

    /**
     * Display a listing of the resource (Redirects to Unified Attendance Management Sheet)
     */
    public function index(Request $request)
    {
        return redirect()->route('attendance-records.sheet', $request->all());
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
            $attendanceRecord->load(['employee', 'project', 'attendanceType', 'attendanceStatus']);
            return view('crm.crud.attendance-records.show', compact('attendanceRecord'));
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
