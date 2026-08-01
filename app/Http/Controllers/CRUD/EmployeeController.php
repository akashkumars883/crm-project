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
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
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
            $roles         = Role::all();
            return view('crm.crud.employees.create', compact('genders', 'employeeTypes', 'bloodGroups', 'departments', 'designations', 'skills', 'roles'));
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
            'user_password' => 'nullable|string|min:6',
            'role_id' => 'nullable|exists:roles,id',
        ]);        
        $lastId = Employee::max('id') ?? 0;
        $nextNum = $lastId + 1;
        $empId = 'HG' . str_pad($nextNum, 5, '0', STR_PAD_LEFT);
        $data = $request->except(['photograph', 'pan', 'aadhaar', 'user_password', 'role_id']);
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
        $password = $request->filled('user_password') ? $request->user_password : ($request->phone ?: '12345678');
        $data['user_password'] = $password;
        $employee = Employee::create($data);

        // Create User account and link via EmployeeUser
        $existingUser = User::where('email', $employee->email)->first();
        if (!$existingUser) {
            $user = User::create([
                'name' => $employee->name,
                'email' => $employee->email,
                'password' => Hash::make($password),
            ]);
            $role = $request->filled('role_id') ? Role::find($request->role_id) : Role::where('name', 'employee')->first();
            if ($role) {
                $user->roles()->attach($role);
            }
        } else {
            $user = $existingUser;
        }

        EmployeeUser::firstOrCreate([
            'employee_id' => $employee->id,
            'user_id' => $user->id,
        ]);

        notify()->success('Created Employee & System Login Account');
        return redirect()->route('employees.index');
    }

    public function show(Employee $employee)
    {
        if (Auth::user()->hasPermission('read-employee')) {
            $employeeId = $employee->id;
            $bills = Bill::where('employee_id', $employeeId)->paginate(8);
            $attendanceRecords = AttendanceRecord::where('employee_id', $employeeId)->paginate(8);
            
            if (\App\Models\BillType::count() == 0) {
                foreach (['Salary / Payout', 'Daily Wage', 'Advance Payment', 'Expense Reimbursement'] as $type) {
                    \App\Models\BillType::firstOrCreate(['name' => $type]);
                }
            }
            if (\App\Models\BillStatus::count() == 0) {
                foreach (['Paid', 'Pending', 'Approved', 'Cancelled'] as $status) {
                    \App\Models\BillStatus::firstOrCreate(['name' => $status]);
                }
            }
            if (\App\Models\PaymentMethod::count() == 0) {
                foreach (['Cash', 'Bank Transfer', 'UPI / GPay / PhonePe'] as $pm) {
                    \App\Models\PaymentMethod::firstOrCreate(['name' => $pm]);
                }
            }

            $billTypes = \App\Models\BillType::all();
            $billStatuses = \App\Models\BillStatus::all();
            $paymentMethods = \App\Models\PaymentMethod::all();
            
            return view('crm.crud.employees.show', compact('employee', 'bills', 'attendanceRecords', 'billTypes', 'billStatuses', 'paymentMethods'));
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
            $roles         = Role::all();
            
            $empUser = $employee->employeeUser;
            $currentUser = $empUser ? $empUser->user : User::where('email', $employee->email)->first();
            $currentRole = $currentUser ? $currentUser->roles->first() : null;

            return view('crm.crud.employees.edit', compact('employee', 'employeeTypes', 'genders', 'bloodGroups', 'departments', 'designations', 'skills', 'roles', 'currentUser', 'currentRole'));
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
            'user_password' => 'nullable|string|min:6',
            'role_id' => 'nullable|exists:roles,id',
        ]);        
        $data = $request->except(['photograph', 'pan', 'aadhaar', 'user_password', 'role_id']);
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
        if ($request->filled('user_password')) {
            $data['user_password'] = $request->user_password;
        }
        $employee->update($data);

        // Update or create linked User account
        $empUser = $employee->employeeUser;
        $user = $empUser ? $empUser->user : User::where('email', $employee->email)->first();

        if ($user) {
            $user->update([
                'name' => $employee->name,
                'email' => $employee->email,
            ]);
            if ($request->filled('user_password')) {
                $user->update([
                    'password' => Hash::make($request->user_password),
                ]);
            }
            if ($request->filled('role_id')) {
                $role = Role::find($request->role_id);
                if ($role) {
                    $user->roles()->sync([$role->id]);
                }
            }
        } else {
            // Create user if didn't exist before
            $password = $request->filled('user_password') ? $request->user_password : ($request->phone ?: '12345678');
            $user = User::create([
                'name' => $employee->name,
                'email' => $employee->email,
                'password' => Hash::make($password),
            ]);
            $role = $request->filled('role_id') ? Role::find($request->role_id) : Role::where('name', 'employee')->first();
            if ($role) {
                $user->roles()->attach($role);
            }
        }

        EmployeeUser::firstOrCreate([
            'employee_id' => $employee->id,
            'user_id' => $user->id,
        ]);

        notify()->success('Updated Employee & Login Account');
        return redirect()->route('employees.index');
    }

    public function destroy(Employee $employee)
    {
        if (Auth::user()->hasPermission('delete-employee')) {
            Storage::deleteDirectory('public/employees/' . $employee->emp_id);
            
            // Delete associated EmployeeUser mapping & User login account
            if ($employee->employeeUser) {
                $user = $employee->employeeUser->user;
                $employee->employeeUser->delete();
                if ($user) {
                    $user->delete();
                }
            }

            $employee->delete();
            notify()->success('Deleted Employee and associated User Account');
            return redirect()->route('employees.index');
        } else {
            abort(403, 'Unauthorized Access');
        }        
    }

    public function myAttendance(Request $request)
    {
        if (Auth::user()->hasPermission('my-attendance')) {
            $authId = Auth::user()->id;
            $empUser = EmployeeUser::where('user_id', $authId)->first();
            $employee = $empUser ? Employee::find($empUser->employee_id) : null;

            // Month selector — default to current month
            $selectedMonth = $request->input('month', now()->format('Y-m'));
            $startOfMonth  = \Carbon\Carbon::parse($selectedMonth . '-01')->startOfMonth();
            $endOfMonth    = \Carbon\Carbon::parse($selectedMonth . '-01')->endOfMonth();
            $monthName     = $startOfMonth->format('F Y');

            // All attendance records for selected month (day-wise table)
            $attendanceRecords = $employee
                ? $employee->attendanceRecords()
                    ->with('attendanceStatus', 'attendanceType', 'project.customer.lead')
                    ->whereBetween('date', [$startOfMonth->format('Y-m-d'), $endOfMonth->format('Y-m-d')])
                    ->orderBy('date', 'asc')
                    ->get()
                : collect();

            // Count summary for selected month
            $presentCount = 0; $halfDayCount = 0; $absentCount = 0;
            foreach ($attendanceRecords as $att) {
                $st = strtolower(optional($att->attendanceStatus)->name ?? '');
                if (str_contains($st, 'present'))      $presentCount++;
                elseif (str_contains($st, 'half'))     $halfDayCount++;
                elseif (str_contains($st, 'absent') || str_contains($st, 'leave')) $absentCount++;
            }

            // Earned wage calculation (30-day base for monthly staff)
            $rate = (float) ($employee->salary ?? 0);
            $empType = strtolower(optional(optional($employee)->employeeType)->name ?? '');
            $isDailyWager = str_contains($empType, 'daily') || str_contains($empType, 'contract');
            if ($isDailyWager) {
                $earnedWages = ($presentCount * $rate) + ($halfDayCount * ($rate / 2));
            } else {
                $effectiveDays = $presentCount + ($halfDayCount * 0.5);
                $earnedWages   = round(($rate / 30) * $effectiveDays, 2);
            }

            // Total paid that month
            $totalPaid = $employee
                ? \App\Models\Bill::where('employee_id', $employee->id)
                    ->whereBetween('bill_date', [$startOfMonth->format('Y-m-d'), $endOfMonth->format('Y-m-d')])
                    ->sum('amount')
                : 0;

            $netBalance = $earnedWages - $totalPaid;

            return view('crm.employees.attendance', compact(
                'employee', 'attendanceRecords',
                'selectedMonth', 'monthName',
                'presentCount', 'halfDayCount', 'absentCount',
                'rate', 'isDailyWager', 'earnedWages', 'totalPaid', 'netBalance'
            ));
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
