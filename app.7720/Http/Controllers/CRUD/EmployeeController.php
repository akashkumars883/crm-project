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
            $employeeTypes = EmployeeType::all();
            $genders = Gender::all();
            $bloodGroups = BloodGroup::all();
            $departments = Department::all();
            $designations = Designation::all();
            $skills = Skill::all();
        return view('crm.crud.employees.create', compact('genders', 'employeeTypes', 'bloodGroups', 'departments', 'designations', 'skills'));
        } else {
            abort(403, 'Unauthorized Access');
        }
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_type_id' => 'required|exists:employee_types,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'gender_id' => 'required|exists:genders,id',
            'blood_group_id' => 'required|exists:blood_groups,id',
            'date_of_birth' => 'required|date',
            'address' => 'required|string',
            'joining_date' => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'skill_paint_id' => 'required|exists:skills,id',
            'skill_polish_id' => 'required|exists:skills,id',
            'salary' => 'required|numeric|min:0',
            'photograph' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'pan' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'aadhaar' => 'nullable|mimes:jpeg,png,jpg,gif,pdf',
        ]);
        $empId = 'HG' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
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
            $employeeTypes = EmployeeType::all();
            $genders = Gender::all();
            $bloodGroups = BloodGroup::all();
            $departments = Department::all();
            $designations = Designation::all();
            $skills = Skill::all();
        return view('crm.crud.employees.edit', compact('employee', 'employeeTypes', 'genders', 'bloodGroups', 'departments', 'designations', 'skills'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'employee_type_id' => 'required|exists:employee_types,id',
            'photograph' => 'nullable|image|mimes:jpg,jpeg,png',
            'pan' => 'nullable|image|mimes:jpg,jpeg,png',
            'aadhaar' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'gender_id' => 'required|exists:genders,id',
            'blood_group_id' => 'required|exists:blood_groups,id',
            'date_of_birth' => 'required|date',
            'address' => 'required|string',
            'joining_date' => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'skill_paint_id' => 'required|exists:skills,id',
            'skill_polish_id' => 'required|exists:skills,id',
            'salary' => 'required|numeric|min:0',
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
            $eId = $empUser->employee_id;
            $employee = Employee::where('id', $eId)->first();
            $attendanceRecords = $employee->attendanceRecords()->latest()->paginate(10);
            // return $attendanceRecords;
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
            $eId = $empUser->employee_id;
            $employee = Employee::where('id', $eId)->first();
            $bills = $employee->bills()->latest()->paginate(10);
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
            $eId = $empUser->employee_id;
            $employee = Employee::where('id', $eId)->first();
            $employeeBankAccount = $employee->employeeBankAccount;
            // return $employeeBankAccount;
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
            $eId = $empUser->employee_id;
            $employee = Employee::where('id', $eId)->first();
            return view('crm.employees.profile', compact('employee'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }
}
