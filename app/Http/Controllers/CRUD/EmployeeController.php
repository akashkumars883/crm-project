<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\Bill;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Gender;
use App\Models\Skill;
use App\Models\BloodGroup;
use App\Models\EmployeeType;
use App\Models\EmployeeUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class EmployeeController extends Controller
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
        if (Auth::user()->hasPermission('manage-employee')) {
            $searchQuery = $request->input('search');
            $employeesQuery = Employee::query();
            if ($searchQuery) {
                $employeesQuery->where('emp_id', 'LIKE', '%' . $searchQuery . '%')
                            ->orWhere('name', 'LIKE', '%' . $searchQuery . '%')
                            ->orWhere('phone', 'LIKE', '%' . $searchQuery . '%')
                            ->orWhere('email', 'LIKE', '%' . $searchQuery . '%');
            }
            $employees = $employeesQuery->paginate(10);
            return view('crm.crud.employees.index', compact('employees'));
        } else {
            abort(403, 'Unauthorized access');
        }
        
    }


    public function create()
    {
        if (Auth::user()->hasPermission('create-employee')) {
            $masterData = Cache::remember('employee_master_dropdowns', 86400, function () {
                if (Gender::count() == 0) {
                    foreach (['Male', 'Female', 'Other'] as $g) { Gender::firstOrCreate(['name' => $g]); }
                }
                if (BloodGroup::count() == 0) {
                    foreach (['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bg) { BloodGroup::firstOrCreate(['name' => $bg]); }
                }
                if (EmployeeType::count() == 0) {
                    foreach (['Full Time', 'Part Time', 'Contract', 'Intern'] as $et) { EmployeeType::firstOrCreate(['name' => $et]); }
                }
                if (Department::count() == 0) {
                    foreach (['Operations', 'Sales', 'Accounts', 'HR'] as $d) { Department::firstOrCreate(['name' => $d]); }
                }
                if (Designation::count() == 0) {
                    foreach (['Project Manager', 'Site Engineer', 'Supervisor', 'Painter', 'Accountant', 'HR Manager'] as $des) { Designation::firstOrCreate(['name' => $des]); }
                }

                return [
                    'employeeTypes' => EmployeeType::all(),
                    'genders'       => Gender::all(),
                    'bloodGroups'   => BloodGroup::all(),
                    'departments'   => Department::all(),
                    'designations'  => Designation::all(),
                    'skills'        => Skill::all(),
                ];
            });

            $employeeTypes = $masterData['employeeTypes'];
            $genders       = $masterData['genders'];
            $bloodGroups   = $masterData['bloodGroups'];
            $departments   = $masterData['departments'];
            $designations  = $masterData['designations'];
            $skills        = $masterData['skills'];
            return view('crm.crud.employees.create', compact('genders', 'employeeTypes', 'bloodGroups', 'departments', 'designations', 'skills'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_type_id' => 'nullable|exists:employee_types,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'gender_id' => 'nullable|exists:genders,id',
            'blood_group_id' => 'nullable|exists:blood_groups,id',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'joining_date' => 'nullable|date',
            'department_id' => 'nullable|exists:departments,id',
            'designation_id' => 'nullable|exists:designations,id',
            'skill_paint_id' => 'nullable|exists:skills,id',
            'skill_polish_id' => 'nullable|exists:skills,id',
            'salary' => 'nullable|numeric|min:0',
            'photograph' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'pan' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'aadhaar' => 'nullable|mimes:jpeg,png,jpg,gif,pdf',
        ]);        
        $lastId = Employee::max('id') ?? 0;
        $nextNum = $lastId + 1;
        $empId = 'HG' . str_pad($nextNum, 5, '0', STR_PAD_LEFT);
        $data = $request->except(['photograph', 'pan', 'aadhaar']);
        $data['emp_id'] = $empId;
        if ($request->hasFile('photograph')) {
            $extension = $request->file('photograph')->getClientOriginalExtension();
            $filename = 'photograph.' . $extension;
            $path = $request->file('photograph')->storeAs('public/employees/' . $empId, $filename);
            $data['photograph'] = 'employees/' . $empId . '/' . $filename;
        }
        if ($request->hasFile('pan')) {
            $extension = $request->file('pan')->getClientOriginalExtension();
            $filename = 'pan.' . $extension;
            $path = $request->file('pan')->storeAs('public/employees/' . $empId, $filename);
            $data['pan'] = 'employees/' . $empId . '/' . $filename;
        }
        if ($request->hasFile('aadhaar')) {
            $extension = $request->file('aadhaar')->getClientOriginalExtension();
            $filename = 'aadhaar.' . $extension;
            $path = $request->file('aadhaar')->storeAs('public/employees/' . $empId, $filename);
            $data['aadhaar'] = 'employees/' . $empId . '/' . $filename;
        }
        Employee::create($data);
        notify()->success('Created Employee');
        return redirect($this->previousUrl);
    }

    public function show(Employee $employee)
    {
        if (Auth::user()->hasPermission('read-employee')) {
            $employeeId = $employee->id;
            $bills = Bill::where('employee_id', $employeeId)->paginate(8);
            $attendanceRecords = AttendanceRecord::where('employee_id', $employeeId)->paginate(8);
            return view('crm.crud.employees.show', compact('employee', 'bills', 'attendanceRecords'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    public function edit(Employee $employee)
    {
        if (Auth::user()->hasPermission('update-employee')) {
            $masterData = Cache::remember('employee_master_dropdowns', 86400, function () {
                if (Gender::count() == 0) {
                    foreach (['Male', 'Female', 'Other'] as $g) { Gender::firstOrCreate(['name' => $g]); }
                }
                if (BloodGroup::count() == 0) {
                    foreach (['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bg) { BloodGroup::firstOrCreate(['name' => $bg]); }
                }
                if (EmployeeType::count() == 0) {
                    foreach (['Full Time', 'Part Time', 'Contract', 'Intern'] as $et) { EmployeeType::firstOrCreate(['name' => $et]); }
                }
                if (Department::count() == 0) {
                    foreach (['Operations', 'Sales', 'Accounts', 'HR'] as $d) { Department::firstOrCreate(['name' => $d]); }
                }
                if (Designation::count() == 0) {
                    foreach (['Project Manager', 'Site Engineer', 'Supervisor', 'Painter', 'Accountant', 'HR Manager'] as $des) { Designation::firstOrCreate(['name' => $des]); }
                }

                return [
                    'employeeTypes' => EmployeeType::all(),
                    'genders'       => Gender::all(),
                    'bloodGroups'   => BloodGroup::all(),
                    'departments'   => Department::all(),
                    'designations'  => Designation::all(),
                    'skills'        => Skill::all(),
                ];
            });

            $employeeTypes = $masterData['employeeTypes'];
            $genders       = $masterData['genders'];
            $bloodGroups   = $masterData['bloodGroups'];
            $departments   = $masterData['departments'];
            $designations  = $masterData['designations'];
            $skills        = $masterData['skills'];
            return view('crm.crud.employees.edit', compact('employee', 'employeeTypes', 'genders', 'bloodGroups', 'departments', 'designations', 'skills'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'employee_type_id' => 'nullable|exists:employee_types,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'gender_id' => 'nullable|exists:genders,id',
            'blood_group_id' => 'nullable|exists:blood_groups,id',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'joining_date' => 'nullable|date',
            'department_id' => 'nullable|exists:departments,id',
            'designation_id' => 'nullable|exists:designations,id',
            'skill_paint_id' => 'nullable|exists:skills,id',
            'skill_polish_id' => 'nullable|exists:skills,id',
            'salary' => 'nullable|numeric|min:0',
            'photograph' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'pan' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'aadhaar' => 'nullable|mimes:jpeg,png,jpg,gif,pdf',
        ]);        
        $data = $request->except(['photograph', 'pan', 'aadhaar']);
        if ($request->hasFile('photograph')) {
            Storage::delete('public/' . $employee->photograph);
            $extension = $request->file('photograph')->getClientOriginalExtension();
            $filename = 'photograph.' . $extension;
            $path = $request->file('photograph')->storeAs('public/employees/' . $employee->emp_id, $filename);
            $data['photograph'] = 'employees/' . $employee->emp_id . '/' . $filename;
        }
        if ($request->hasFile('pan')) {
            Storage::delete('public/' . $employee->pan);
            $extension = $request->file('pan')->getClientOriginalExtension();
            $filename = 'pan.' . $extension;
            $path = $request->file('pan')->storeAs('public/employees/' . $employee->emp_id, $filename);
            $data['pan'] = 'employees/' . $employee->emp_id . '/' . $filename;
        }
        if ($request->hasFile('aadhaar')) {
            Storage::delete('public/' . $employee->aadhaar);
            $extension = $request->file('aadhaar')->getClientOriginalExtension();
            $filename = 'aadhaar.' . $extension;
            $path = $request->file('aadhaar')->storeAs('public/employees/' . $employee->emp_id, $filename);
            $data['aadhaar'] = 'employees/' . $employee->emp_id . '/' . $filename;
        }
        $employee->update($data);
        notify()->success('Updated Employee');
        return redirect($this->previousUrl);
    }

    public function destroy(Employee $employee)
    {
        if (Auth::user()->hasPermission('delete-employee')) {
            Storage::deleteDirectory('public/employees/' . $employee->emp_id);
            $employee->delete();
            notify()->success('Deleted Employee');
            return redirect($this->previousUrl);
        } else {
            abort(403, 'Unauthorized Access');
        }        
    }

    public function myAttendance()
    {
        if (Auth::user()->hasPermission('my-attendance')) {
            $authId = Auth::user()->id;
            $empUser = EmployeeUser::where('user_id', $authId)->first();
            $employee = $empUser ? Employee::find($empUser->employee_id) : null;
            $attendanceRecords = $employee ? $employee->attendanceRecords()->latest()->paginate(10) : new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
            return view('crm.employees.attendance', compact('attendanceRecords'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    public function empBills()
    {
        if (Auth::user()->hasPermission('employee-bills')) {
            $authId = Auth::user()->id;
            $empUser = EmployeeUser::where('user_id', $authId)->first();
            $employee = $empUser ? Employee::find($empUser->employee_id) : null;
            $bills = $employee ? $employee->bills()->latest()->paginate(10) : new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
            return view('crm.employees.bills', compact('bills'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    public function myBank()
    {
        if (Auth::user()->hasPermission('my-bank-accounts')) {
            $authId = Auth::user()->id;
            $empUser = EmployeeUser::where('user_id', $authId)->first();
            $employee = $empUser ? Employee::find($empUser->employee_id) : null;
            $employeeBankAccount = $employee ? $employee->employeeBankAccount : null;
            return view('crm.employees.bank-accounts', compact('employeeBankAccount'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    public function empProfile()
    {
        if (Auth::user()->hasPermission('employee-profile')) {
            $authId = Auth::user()->id;
            $empUser = EmployeeUser::where('user_id', $authId)->first();
            $employee = $empUser ? Employee::find($empUser->employee_id) : null;
            return view('crm.employees.profile', compact('employee'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $authId = Auth::user()->id;
        $empUser = EmployeeUser::where('user_id', $authId)->first();
        if (!$empUser) return redirect()->back()->with('error', 'Employee profile not found.');
        
        $employeeId = $empUser->employee_id;

        $attendance = new AttendanceRecord();
        $attendance->employee_id = $employeeId;
        $attendance->project_id = $request->project_id;
        $attendance->date = now()->toDateString();
        // Fallback to first attendance type and status if not provided
        $firstType = \App\Models\AttendanceType::first();
        $firstStatus = \App\Models\AttendanceStatus::first();
        $attendance->attendance_type_id = $firstType ? $firstType->id : 1; 
        $attendance->attendance_status_id = $firstStatus ? $firstStatus->id : 1;
        $attendance->latitude = $request->latitude;
        $attendance->longitude = $request->longitude;
        $attendance->created_by = $authId;
        $attendance->updated_by = $authId;

        if ($request->hasFile('photo')) {
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filename = 'attendance_' . time() . '.' . $extension;
            $path = $request->file('photo')->storeAs('public/attendance/' . $employeeId, $filename);
            $attendance->photo = 'attendance/' . $employeeId . '/' . $filename;
        }

        $attendance->save();

        notify()->success('Checked In Successfully!');
        return redirect()->back();
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'daily_report' => 'required|string|max:1000'
        ]);

        $authId = Auth::user()->id;
        $empUser = EmployeeUser::where('user_id', $authId)->first();
        if (!$empUser) return redirect()->back()->with('error', 'Employee profile not found.');

        $employeeId = $empUser->employee_id;
        $todayRecord = AttendanceRecord::where('employee_id', $employeeId)
                        ->whereDate('date', now()->toDateString())
                        ->first();
                        
        if ($todayRecord) {
            $todayRecord->checkout_time = now();
            $todayRecord->daily_report = $request->daily_report;
            $todayRecord->save();
            notify()->success('Checked Out Successfully!');
        } else {
            notify()->error('No Check-In record found for today.');
        }

        return redirect()->back();
    }
}
