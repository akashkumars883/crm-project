<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentStatus;
use Illuminate\Support\Facades\Auth;

class PaymentStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-payment-status')) {
            $paymentStatuses = PaymentStatus::paginate(10);
            return view('crm.fields.payment-statuses.index', compact('paymentStatuses'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-payment-status')) {
            return view('crm.fields.payment-statuses.create');
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
            'name' => 'required|unique:payment_statuses',
        ]);

        PaymentStatus::create([
            'name' => $request->name,
        ]);

        notify()->success('Payment Status has been created');
        return redirect()->route('payment-statuses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentStatus $paymentStatus)
    {
        if (Auth::user()->hasPermission('read-payment-status')) {
            return view('crm.fields.payment-statuses.show', compact('paymentStatus'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentStatus $paymentStatus)
    {
        if (Auth::user()->hasPermission('update-payment-status')) {
            return view('crm.fields.payment-statuses.edit', compact('paymentStatus'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentStatus $paymentStatus)
    {
        $request->validate([
            'name' => 'required|unique:payment_statuses,name,' . $paymentStatus->id,
        ]);

        $paymentStatus->update($request->all());

        notify()->success('Payment Status Updated');
        return redirect()->route('payment-statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentStatus $paymentStatus)
    {
        if (Auth::user()->hasPermission('delete-payment-status')) {
            $paymentStatus->delete();
            notify()->success('Payment Status Deleted');
            return redirect()->route('payment-statuses.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
