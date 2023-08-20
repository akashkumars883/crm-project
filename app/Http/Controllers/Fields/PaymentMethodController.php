<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-payment-method')) {
            $paymentMethods = PaymentMethod::paginate(10);
            return view('crm.fields.payment-methods.index', compact('paymentMethods'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-payment-method')) {
            return view('crm.fields.payment-methods.create');
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
            'name' => 'required|unique:payment_methods',
        ]);

        PaymentMethod::create([
            'name' => $request->name,
        ]);

        notify()->success('Payment Method has been created');
        return redirect()->route('payment-methods.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMethod $paymentMethod)
    {
        if (Auth::user()->hasPermission('read-payment-method')) {
            return view('crm.fields.payment-methods.show', compact('paymentMethod'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        if (Auth::user()->hasPermission('update-payment-method')) {
            return view('crm.fields.payment-methods.edit', compact('paymentMethod'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required|unique:payment_methods,name,' . $paymentMethod->id,
        ]);

        $paymentMethod->update($request->all());

        notify()->success('Payment Method Updated');
        return redirect()->route('payment-methods.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        if (Auth::user()->hasPermission('delete-payment-method')) {
            $paymentMethod->delete();
            notify()->success('Payment Method Deleted');
            return redirect()->route('payment-methods.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
