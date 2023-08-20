<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceType;
use App\Models\InvoiceStatus;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    protected $previousUrl;

    public function __construct()
    {
        $this->previousUrl = URL::previous();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasPermission('manage-invoice')) {
            // Get all lead statuses with their corresponding lead counts
            $invoiceTypeAnalytics = InvoiceType::select('id', 'name')
                ->withCount('invoices')
                ->get();
            // Get all Invoice Status with their corresponding lead counts
            $invoiceStatusAnalytics = InvoiceStatus::select('id', 'name')
                ->withCount('invoices')
                ->get();
            $searchQuery = $request->input('search');
            $invoicesQuery = Invoice::with(['invoiceType', 'invoiceStatus', 'lead']);
            if ($searchQuery) {
                $invoicesQuery->where(function ($query) use ($searchQuery) {
                    $query->where('id', 'LIKE', '%' . $searchQuery . '%')
                        ->orWhereHas('invoiceType', function ($typeQuery) use ($searchQuery) {
                            $typeQuery->where('name', 'LIKE', '%' . $searchQuery . '%');
                        })
                        ->orWhereHas('invoiceStatus', function ($statusQuery) use ($searchQuery) {
                            $statusQuery->where('name', 'LIKE', '%' . $searchQuery . '%');
                        })
                        ->orWhereHas('lead', function ($leadQuery) use ($searchQuery) {
                            $leadQuery->where('name', 'LIKE', '%' . $searchQuery . '%');
                        });
                });
            }
            $invoices = $invoicesQuery->latest()->paginate(10);
            return view('crm.crud.invoices.index', compact('invoices', 'invoiceTypeAnalytics', 'invoiceStatusAnalytics'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasPermission('create-invoice')) {
            return view('crm.crud.invoices.create');
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        if (Auth::user()->hasPermission('read-invoice')) {
            $invoice->load(['invoiceType', 'lead', 'invoiceStatus']); // Load the 'status' relationship
            return view('crm.crud.invoices.show', compact('invoice'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        if (Auth::user()->hasPermission('update-invoice')) {
            return view('crm.crud.invoices.edit');
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        if (Auth::user()->hasPermission('delete-invoice')) {
            // Delete attachments if they exist
            if (!empty($invoice->attachments)) {
                foreach ($invoice->attachments as $attachment) {
                    Storage::delete('public/' . $attachment);
                }
            }

            $invoice->delete();
            notify()->success('Invoice Deleted');
            return redirect($this->previousUrl);
        } else {
            abort(403, 'Unauthorized Access');
        }
    }
}
