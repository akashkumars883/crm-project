<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Models\Employee;
use App\Models\EmployeeUser;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployeeUserController extends Controller
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
        if (Auth::user()->hasPermission('manage-employee-user')) {
            $searchQuery = $request->input('search');
            $employeeUserQuery = EmployeeUser::with(['employee', 'user']);
            if ($searchQuery) {
                $employeeUserQuery->where(function ($query) use ($searchQuery) {
                    $query->whereHas('employee', function ($employeeQuery) use ($searchQuery) {
                        $employeeQuery->where('id', 'LIKE', '%' . $searchQuery . '%')
                                ->orWhere('name', 'LIKE', '%' . $searchQuery . '%')
                                ->orWhere('phone', 'LIKE', '%' . $searchQuery . '%')
                                ->orWhere('email', 'LIKE', '%' . $searchQuery . '%')
                                ->orWhere('address', 'LIKE', '%' . $searchQuery . '%');
                    });
                });
            }
            $employeeUsers = $employeeUserQuery->paginate(10);
            return view('crm.crud.employee-users.index', compact('employeeUsers'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-employee-user')):
            $employees = Employee::all();
            $users = User::all();
            return view('crm.crud.employee-users.create', compact('employees', 'users'));
        else:
            abort(403, 'Unauthorized Access');
        endif;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'user_password' => 'required|min:6',
        ]);

        // Retrieve the Employee's information
        $employee = Employee::findOrFail($request->employee_id);

        // Check if a user already exists with the Employee's email
        $existingUser = User::where('email', $employee->email)->first();

        if (!$existingUser) {
            // Create a new user with the employee's name and email
            $newUser = User::create([
                'name' => $employee->name,
                'email' => $employee->email,
                'password' => Hash::make($request->user_password),
            ]);

            // Attach the "client" role to the user
            $employeeRole = Role::where('name', 'employee')->first();
            if ($employeeRole) {
                $newUser->roles()->attach($employeeRole);
            }

            notify()->success('User Created and Assigned to Employee');
        } else {
            // A user with the employees's email already exists
            notify()->error('A User with that Employee Email already exists');
        }

        // Create the EmployeeUser with the Employee ID
        EmployeeUser::create([
            'employee_id' => $request->employee_id,
            'user_id' => $existingUser ? $existingUser->id : $newUser->id,
        ]);

        notify()->success('Employee User Created');
        return redirect($this->previousUrl);
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeUser $employeeUser)
    {
        if (Auth::user()->hasPermission('read-employee-user')) {
            return view('crm.crud.employee-users.show', compact('employeeUser'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeUser $employeeUser)
    {
        if (Auth::user()->hasPermission('update-employee-user')) {
            $employees = Employee::all();
            $users = User::all();
            return view('crm.crud.employee-users.edit', compact('employees', 'users', 'employeeUser'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, EmployeeUser $employeeUser)
    // {
    //     $request->validate([
    //         'employee_id' => 'required|exists:employees,id',
    //         'user_password' => 'nullable|min:6',
    //     ]);

    //     // Retrieve the employee's information
    //     $employee = Employee::findOrFail($request->employee_id);

    //     // Update the Employee User's Employee ID
    //     $employeeUser->update([
    //         'employee_id' => $request->employee_id,
    //     ]);

    //     // Check if a user already exists with the Employee User's email
    //     $existingUser = User::where('email', $employee->email)->first();

    //     if (!$existingUser) {
    //         // If a new password is provided, update the user's password
    //         if ($request->has('user_password')) {
    //             $employeeUser->user->update([
    //                 'password' => Hash::make($request->user_password),
    //             ]);
    //         }

    //         // If the user is assigned to the Employee User, update the user's name and email
    //         if ($employeeUser->user) {
    //             $employeeUser->user->update([
    //                 'name' => $employee->name,
    //                 'email' => $employee->email,
    //             ]);
    //         }

    //         notify()->success('User Updated and Employee User Information Updated');
    //     } else {
    //         // A user with the Employee's email already exists
    //         notify()->error('A User with that Employee Email already exists');
    //     }

    //     return redirect($this->previousUrl);
    // }

    public function update(Request $request, EmployeeUser $employeeUser)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'user_password' => 'nullable|min:6',
        ]);

        // Retrieve the employee's information
        $employee = Employee::findOrFail($request->employee_id);

        // Update the Employee User's Employee ID
        $employeeUser->update([
            'employee_id' => $request->employee_id,
        ]);

        if ($employeeUser->user) {
            // If the user exists, update the name and email
            $employeeUser->user->update([
                'name' => $employee->name,
                'email' => $employee->email,
            ]);

            // Update the password only if provided
            if ($request->has('user_password')) {
                $employeeUser->user->update([
                    'password' => Hash::make($request->user_password),
                ]);
            }

            notify()->success('User Updated and Employee User Information Updated');
        } else {
            notify()->error('No User found for this Employee');
        }

        return redirect($this->previousUrl);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeUser $employeeUser)
    {
        if (Auth::user()->hasPermission('delete-employee-user')) {
            $employeeUser->delete();
            notify()->success('Customer Deleted');
            return redirect($this->previousUrl);
        } else {
            abort(403, 'Unauthorized Access');
        }        
    }
}
