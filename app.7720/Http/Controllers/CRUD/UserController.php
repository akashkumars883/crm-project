<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a list of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::user()->hasPermission('manage-users')) {
            $chart_options = [
                'chart_title' => 'Users by month',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\User',
                'group_by_field' => 'created_at',
                'group_by_period' => 'month',
                'date_format' => 'M',
                'chart_type' => 'bar',
            ];

            $chart1 = new LaravelChart($chart_options);

            $chart_options = [
                'chart_title' => 'Users by Week',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\User',
                'group_by_field' => 'created_at',
                'group_by_period' => 'week',
                'date_format' => 'M',
                'chart_type' => 'line',
            ];
            $chart2 = new LaravelChart($chart_options);            

            // $chart_options = [
            //     'chart_title' => 'Users by Role',
            //     'report_type' => 'group_by_string',
            //     'model' => 'App\Models\RoleUser',
            //     'group_by_field' => 'user_id, role_id',
            //     'group_by_period' => 'month',
            //     'date_format' => 'M',
            //     'chart_type' => 'bar',
            //     'series_labels' => ['Users'],
            //     'colors' => ['#1f77b4'],
            //     'query' => function (Builder $query) {
            //         return $query->select('roles.id', 'roles.name', 'users.count')
            //             ->join('users', 'users.role_id', '=', 'roles.id');
            //     },
            // ];
            // $chart3 = new LaravelChart($chart_options);

            $chart_options = [
                'chart_title' => 'User Counts by Role',
                'report_type' => 'group_by_string',
                'model' => Role::class,
                'group_by_field' => 'name', // Group by role name
                'aggregate_function' => 'sum', // Use sum to aggregate user counts
                'aggregate_field' => 'role_user.count', // User counts attribute
                'chart_type' => 'bar', // Use bar chart
                'series_labels' => ['Users'],
                'colors' => ['#1f77b4'],
                'query' => function (Builder $query) {
                    return $query->select('roles.id', 'roles.name', 'role_user.count')
                        ->join('role_user', 'role_user.role_id', '=', 'roles.id');
                },
            ];

            $chart3 = new LaravelChart($chart_options);

            $searchQuery = $request->input('search');
            // Query users with search criteria
            $usersQuery = User::with('roles');
            if ($searchQuery) {
                $usersQuery->where('name', 'LIKE', '%' . $searchQuery . '%')
                        ->orWhere('email', 'LIKE', '%' . $searchQuery . '%');
            }
            // Retrieve the paginated users
            $users = $usersQuery->paginate(10);
            return view('crm.crud.users.index', compact('users', 'chart1', 'chart2', 'chart3'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-users')) {
            $roles = Role::all(); 
            return view('crm.crud.users.create', compact('roles'));
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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'roles' => 'array',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles); // Assign roles to the user
        }

        notify()->success('User Created');
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if (Auth::user()->hasPermission('read-users')) {
            $userRoles = $user->roles;
            $userPermissions = $user->permissions;
            return view('crm.crud.users.show', compact('user', 'userRoles', 'userPermissions'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (Auth::user()->hasPermission('update-users')) {
            $roles = Role::all(); 
            return view('crm.crud.users.edit', compact('user', 'roles'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'roles' => 'array',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles); // Update roles for the user
        } else {
            $user->roles()->detach(); // Remove all roles if no roles are selected
        }

        notify()->success('User Updated');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (Auth::user()->hasPermission('delete-users')) {
            $user->delete();
            notify()->success('User Deleted');
            return redirect()->route('users.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
