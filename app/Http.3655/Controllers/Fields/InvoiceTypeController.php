<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InvoiceType;
use Illuminate\Support\Facades\Auth;

class InvoiceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-invoice-type')) {
            $invoiceTypes = InvoiceType::paginate(10);
            return view('crm.fields.invoice-types.index', compact('invoiceTypes'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-invoice-type')) {
            return view('crm.fields.invoice-types.create');
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
            'name' => 'required|unique:invoice_types',
        ]);

        InvoiceType::create([
            'name' => $request->name,
        ]);

        notify()->success('Invoice Type has been created');
        return redirect()->route('invoice-types.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceType $invoiceType)
    {
        if (Auth::user()->hasPermission('read-invoice-type')) {
            return view('crm.fields.invoice-types.show', compact('invoiceType'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceType $invoiceType)
    {
        if (Auth::user()->hasPermission('update-invoice-type')) {
            return view('crm.fields.invoice-types.edit', compact('invoiceType'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoiceType $invoiceType)
    {
        $request->validate([
            'name' => 'required|unique:invoice_types,name,' . $invoiceType->id,
        ]);

        $invoiceType->update($request->all());

        notify()->success('Invoice Type Updated');
        return redirect()->route('invoice-types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoiceType $invoiceType)
    {
        if (Auth::user()->hasPermission('delete-invoice-type')) {
            $invoiceType->delete();
            notify()->success('Invoice Type Deleted');
            return redirect()->route('invoice-types.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
