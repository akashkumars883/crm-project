<?php

namespace App\Http\Controllers\Fields;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InvoiceStatus;
use Illuminate\Support\Facades\Auth;

class InvoiceStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-invoice-status')) {
            $invoiceStatuses = InvoiceStatus::paginate(10);
            return view('crm.fields.invoice-statuses.index', compact('invoiceStatuses'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-invoice-status')) {
            return view('crm.fields.invoice-statuses.create');
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
            'name' => 'required|unique:invoice_statuses',
        ]);

        InvoiceStatus::create([
            'name' => $request->name,
        ]);

        notify()->success('Invoice Status has been created');
        return redirect()->route('invoice-statuses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceStatus $invoiceStatus)
    {
        if (Auth::user()->hasPermission('read-invoice-status')) {
            return view('crm.fields.invoice-statuses.show', compact('invoiceStatus'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceStatus $invoiceStatus)
    {
        if (Auth::user()->hasPermission('update-invoice-status')) {
            return view('crm.fields.invoice-statuses.edit', compact('invoiceStatus'));
        } else {
            abort(403, 'Unauthorized Access');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoiceStatus $invoiceStatus)
    {
        $request->validate([
            'name' => 'required|unique:invoice_statuses,name,' . $invoiceStatus->id,
        ]);

        $invoiceStatus->update($request->all());

        notify()->success('Invoice Status Updated');
        return redirect()->route('invoice-statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoiceStatus $invoiceStatus)
    {
        if (Auth::user()->hasPermission('delete-invoice-status')) {
            $invoiceStatus->delete();
            notify()->success('Invoice Status Deleted');
            return redirect()->route('invoice-statuses.index');
        } else {
            abort(403, 'Unauthorized Access');
        }

    }
}
