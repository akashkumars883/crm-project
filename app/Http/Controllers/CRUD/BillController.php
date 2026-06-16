<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillStatus;
use App\Models\BillType;
use App\Models\PaymentMethod;
use App\Models\Project;
use App\Models\Employee;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class BillController extends Controller
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
        if (Auth::user()->hasPermission('manage-bill')) {
            $chart_options = [
                'chart_title' => 'Bills by month',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\Bill',
                'group_by_field' => 'created_at',
                'group_by_period' => 'month',
                'date_format' => 'M',
                'chart_type' => 'bar',
            ];

            $chart1 = new LaravelChart($chart_options);

            $chart_options = [
                'chart_title' => 'Bills by Type',
                'report_type' => 'group_by_relationship',
                'model' => 'App\Models\Bill',
                'relationship_name' => 'billType',
                'group_by_field' => 'name',
                'chart_type' => 'bar',
            ];

            $chart2 = new LaravelChart($chart_options);

            $chart_options = [
                'chart_title' => 'Bills by Status',
                'report_type' => 'group_by_relationship',
                'model' => 'App\Models\Bill',
                'relationship_name' => 'billStatus',
                'group_by_field' => 'name',
                'chart_type' => 'bar',
            ];

            $chart3 = new LaravelChart($chart_options);

            $searchQuery = $request->input('search');
            $billsQuery = Bill::with(['billType', 'billStatus', 'paymentMethod', 'project', 'inventory', 'employee']);
            if ($searchQuery) {
                $billsQuery->where(function ($query) use ($searchQuery) {
                    $query->where('reference', 'LIKE', '%' . $searchQuery . '%')
                        ->orWhereHas('billType', function ($typeQuery) use ($searchQuery) {
                            $typeQuery->where('name', 'LIKE', '%' . $searchQuery . '%');
                        })
                        ->orWhereHas('billStatus', function ($statusQuery) use ($searchQuery) {
                            $statusQuery->where('name', 'LIKE', '%' . $searchQuery . '%');
                        })
                        ->orWhereHas('project', function ($projectQuery) use ($searchQuery) {
                            $projectQuery->where('id', 'LIKE', '%' . $searchQuery . '%');
                        })
                        ->orWhereHas('inventory', function ($inventoryQuery) use ($searchQuery) {
                            $inventoryQuery->where('name', 'LIKE', '%' . $searchQuery . '%');
                        })
                        ->orWhereHas('employee', function ($employeeQuery) use ($searchQuery) {
                            $employeeQuery->where('name', 'LIKE', '%' . $searchQuery . '%');
                        });
                });
            }
            $bills = $billsQuery->latest()->paginate(10);
            return view('crm.crud.bills.index', compact('bills', 'chart1', 'chart2', 'chart3'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-bill')) {
            $billTypes = BillType::all();
            $billStatuses = BillStatus::all();
            $paymentMethods = PaymentMethod::all();
            $projects = Project::all();
            $inventories = Inventory::all();
            $employees = Employee::all();

            return view('crm.crud.bills.create', compact('billTypes', 'billStatuses', 'paymentMethods', 'projects', 'inventories', 'employees'));
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
            'bill_type_id' => 'required|exists:bill_types,id',
            'reference' => 'nullable|string|max:255',
            'amount' => 'required|numeric',
            'bill_date' => 'required|date',
            'due_date' => 'required|date',
            'bill_status_id' => 'required|exists:bill_statuses,id',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'project_id' => 'nullable|exists:projects,id',
            'inventory_id' => 'nullable|exists:inventories,id',
            'employee_id' => 'nullable|exists:employees,id',
            'notes' => 'nullable|string',
            'vendor_gstin' => 'nullable|string|max:15',
            'tax_percent' => 'nullable|numeric|min:0|max:100',
            'tax_amount' => 'nullable|numeric|min:0',
            'attachments' => 'nullable|array|max:5', 
            'attachments.*' => 'mimes:jpg,jpeg,png,pdf|max:2048',  
        ]);

        $data = $request->except('attachments');

        if ($request->hasFile('attachments')) {
            $attachments = [];
            foreach ($request->file('attachments') as $attachment) {
                $extension = $attachment->getClientOriginalExtension();
                $filename = $request->bill_type_id . '_' . uniqid() . '.' . $extension;
                $attachment->storeAs('public/bills', $filename);
                $attachments[] = 'bills/' . $filename; // Save the attachment path in 'bills' folder
            }
            $data['attachments'] = $attachments;
        }

        Bill::create($data);
        notify()->success('Bill Created');
        return redirect($this->previousUrl);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bill $bill)
    {
        if (Auth::user()->hasPermission('read-bill')) {
            return view('crm.crud.bills.show', compact('bill'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bill $bill)
    {
        if (Auth::user()->hasPermission('update-bill')) {
            $billTypes = BillType::all();
            $billStatuses = BillStatus::all();
            $paymentMethods = PaymentMethod::all();
            $projects = Project::all();
            $inventories = Inventory::all();
            $employees = Employee::all();
            return view('crm.crud.bills.edit', compact('bill', 'billTypes', 'billStatuses', 'paymentMethods', 'projects', 'inventories', 'employees'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bill $bill)
    {
        $request->validate([
            'bill_type_id' => 'required|exists:bill_types,id',
            'reference' => 'nullable|string|max:255',
            'amount' => 'required|numeric',
            'bill_date' => 'required|date',
            'due_date' => 'required|date',
            'bill_status_id' => 'required|exists:bill_statuses,id',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'project_id' => 'nullable|exists:projects,id',
            'inventory_id' => 'nullable|exists:inventories,id',
            'employee_id' => 'nullable|exists:employees,id',
            'notes' => 'nullable|string',
            'vendor_gstin' => 'nullable|string|max:15',
            'tax_percent' => 'nullable|numeric|min:0|max:100',
            'tax_amount' => 'nullable|numeric|min:0',
            'attachments' => 'nullable|array|max:5', 
            'attachments.*' => 'mimes:jpg,jpeg,png,pdf|max:2048', 
        ]);

        $data = $request->except('attachments');

        if ($request->hasFile('attachments')) {
            $attachments = [];
            foreach ($request->file('attachments') as $attachment) {
                $extension = $attachment->getClientOriginalExtension();
                $filename = $request->bill_type_id . '_' . uniqid() . '.' . $extension;
                $attachment->storeAs('public/bills', $filename);
                $attachments[] = 'bills/' . $filename; // Save the attachment path in 'bills' folder
            }
            $data['attachments'] = $attachments;
        }

        $bill->update($data);
        notify()->success('Bill Updated');
        return redirect($this->previousUrl);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill $bill)
    {
        if (Auth::user()->hasPermission('delete-bill')) {
            $bill->delete();
            notify()->success('Bill Deleted');
        } else {
            abort(403, 'Unauthorized Access');
        }
    }
}
