<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EmployeeBankAccount;
use Illuminate\Support\Facades\URL;
use App\Models\Employee;

class EmployeeBankAccountController extends Controller
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
        if (Auth::user()->hasPermission('manage-employee-bank-account')) {
            $searchQuery = $request->input('search');
            $employeeBankAccountsQuery = EmployeeBankAccount::query();
            if ($searchQuery) {
                $employeeBankAccountsQuery->whereHas('employee', function ($query) use ($searchQuery) {
                    $query->where('emp_id', 'LIKE', '%' . $searchQuery . '%')
                        ->orWhere('full_name', 'LIKE', '%' . $searchQuery . '%')
                        ->orWhere('phone', 'LIKE', '%' . $searchQuery . '%')
                        ->orWhere('email', 'LIKE', '%' . $searchQuery . '%');
                })
                ->orWhere('ifsc', 'LIKE', '%' . $searchQuery . '%');
            }
            $employeeBankAccounts = $employeeBankAccountsQuery->paginate(10);
            return view('crm.crud.employee-bank-accounts.index', compact('employeeBankAccounts'));
        } else {
            abort(403, 'Unauthorized access');
        }       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-employee-bank-account')) {
            $employees = Employee::all();
            return view('crm.crud.employee-bank-accounts.create', compact('employees'));
        } else {
            abort(403, 'Unauthorized access');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'emp_id' => 'required|exists:employees,id',
            'bank_name' => 'required',
            'branch' => 'required',
            'ifsc' => 'required',
            'account_name' => 'required',
            'account_number' => 'required',
            'upi' => 'nullable',
            'phonepe' => 'nullable',
            'googlepay' => 'nullable',
            'paytm' => 'nullable',
        ]);

        EmployeeBankAccount::create($request->all());
        notify()->success('Employee Bank Account Added');
        return redirect($this->previousUrl);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (Auth::user()->hasPermission('read-employee-bank-account')) {
            $employeeBankAccount = EmployeeBankAccount::findOrFail($id);
            return view('crm.crud.employee-bank-accounts.show', compact('employeeBankAccount'));
        } else {
            abort(403, 'Unauthorized access');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (Auth::user()->hasPermission('update-employee-bank-account')) {
            $employeeBankAccount = EmployeeBankAccount::findOrFail($id);
            $employees = Employee::all();
            return view('crm.crud.employee-bank-accounts.edit', compact('employeeBankAccount', 'employees'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'emp_id' => 'required|exists:employees,id',
            'bank_name' => 'required',
            'branch' => 'required',
            'ifsc' => 'required',
            'account_name' => 'required',
            'account_number' => 'required',
            'upi' => 'nullable',
            'phonepe' => 'nullable',
            'googlepay' => 'nullable',
            'paytm' => 'nullable',
        ]);

        $employeeBankAccount = EmployeeBankAccount::findOrFail($id);
        $employeeBankAccount->update($request->all());
        notify()->success('Employee Bank Account Updated');
        return redirect($this->previousUrl);                
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Auth::user()->hasPermission('delete-employee-bank-account')) {
            $employeeBankAccount = EmployeeBankAccount::findOrFail($id);
            $employeeBankAccount->delete();
            notify()->success('Deleted Employee Bank Account');
            return redirect($this->previousUrl);
        } else {
            abort(403, 'Unauthorized access');
        }
        
    }
}
