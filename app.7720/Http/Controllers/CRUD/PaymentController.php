<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\PaymentStatus;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class PaymentController extends Controller
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
        if (Auth::user()->hasPermission('manage-payment')) {
            $chart_options = [
                'chart_title' => 'Payments by month',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\Payment',
                'group_by_field' => 'created_at',
                'group_by_period' => 'month',
                'date_format' => 'M',
                'chart_type' => 'bar',
            ];

            $chart1 = new LaravelChart($chart_options);
            
            $chart_options = [
                'chart_title' => 'Payments By Status',
                'report_type' => 'group_by_relationship',
                'model' => 'App\Models\Payment',
                'relationship_name' => 'paymentStatus',
                'group_by_field' => 'name',
                'chart_type' => 'bar',
            ];

            $chart2 = new LaravelChart($chart_options);

            $chart_options = [
                'chart_title' => 'Payments By Method',
                'report_type' => 'group_by_relationship',
                'model' => 'App\Models\Payment',
                'relationship_name' => 'paymentMethod',
                'group_by_field' => 'name',
                'chart_type' => 'bar',
            ];

            $chart3 = new LaravelChart($chart_options);

            $searchQuery = $request->input('search');
            $paymentsQuery = Payment::with(['paymentStatus', 'paymentMethod', 'customer', 'project']);
            if ($searchQuery) {
                $paymentsQuery->where(function ($query) use ($searchQuery) {
                    $query->where('reference', 'LIKE', '%' . $searchQuery . '%')
                        ->orWhereHas('paymentStatus', function ($statusQuery) use ($searchQuery) {
                            $statusQuery->where('name', 'LIKE', '%' . $searchQuery . '%');
                        })
                        ->orWhereHas('paymentMethod', function ($methodQuery) use ($searchQuery) {
                            $methodQuery->where('name', 'LIKE', '%' . $searchQuery . '%');
                        })
                        ->orWhereHas('customer', function ($customerQuery) use ($searchQuery) {
                            $customerQuery->where('id', 'LIKE', '%' . $searchQuery . '%');
                        })
                        ->orWhereHas('project', function ($projectQuery) use ($searchQuery) {
                            $projectQuery->where('id', 'LIKE', '%' . $searchQuery . '%');
                        });
                });
            }
            $payments = $paymentsQuery->latest()->paginate(10);
            return view('crm.crud.payments.index', compact('payments', 'chart1', 'chart2', 'chart3'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-payment')) {
            $paymentMethods = PaymentMethod::all();
            $paymentStatuses = PaymentStatus::all();
            $customers = Customer::all();
            $projects = Project::all();
            return view('crm.crud.payments.create', compact('paymentMethods', 'paymentStatuses', 'customers', 'projects'));
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
            'reference' => 'nullable|string|max:255',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'payment_status_id' => 'required|exists:payment_statuses,id',
            'customer_id' => 'nullable|exists:customers,id',
            'project_id' => 'nullable|exists:projects,id',
            'amount' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        Payment::create($validatedData);
        notify()->success('Payment Created');
        return redirect($this->previousUrl);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        if (Auth::user()->hasPermission('read-payment')) {
            $payment->load(['paymentMethod', 'paymentStatus', 'customer', 'project']);
            return view('crm.crud.payments.show', compact('payment'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        if (Auth::user()->hasPermission('update-payment')) {
            $paymentMethods = PaymentMethod::all();
            $paymentStatuses = PaymentStatus::all();
            $customers = Customer::all();
            $projects = Project::all();
            return view('crm.crud.payments.edit', compact('paymentMethods', 'paymentStatuses', 'payment', 'customers', 'projects'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validatedData = $request->validate([
            'reference' => 'nullable|string|max:255',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'payment_status_id' => 'required|exists:payment_statuses,id',
            'customer_id' => 'nullable|exists:customers,id',
            'project_id' => 'nullable|exists:projects,id',
            'amount' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        $payment->update($validatedData);
        notify()->success('Payment Updated');
        return redirect($this->previousUrl);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        if (Auth::user()->hasPermission('delete-payment')) {
            $payment->delete();
            notify('Payment Deleted');
            return redirect($this->previousUrl);
        } else {
            abort(403, 'Unauthorized Access');
        }
    }
}
