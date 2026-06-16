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
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

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
    public function index(Request $request)
    {
        if (Auth::user()->hasPermission('manage-invoice')) {
            $chart_options = [
                'chart_title' => 'Invoices by month',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\Invoice',
                'group_by_field' => 'created_at',
                'group_by_period' => 'month',
                'date_format' => 'M',
                'chart_type' => 'bar',
            ];

            $chart1 = new LaravelChart($chart_options);

            $chart_options = [
                'chart_title' => 'Invoice by Type',
                'report_type' => 'group_by_relationship',
                'model' => 'App\Models\Invoice',
                'relationship_name' => 'invoiceType',
                'group_by_field' => 'name',
                'chart_type' => 'bar',
            ];

            $chart2 = new LaravelChart($chart_options);

            $chart_options = [
                'chart_title' => 'Invoice by Status',
                'report_type' => 'group_by_relationship',
                'model' => 'App\Models\Invoice',
                'relationship_name' => 'invoiceStatus',
                'group_by_field' => 'name',
                'chart_type' => 'bar',
            ];

            $chart3 = new LaravelChart($chart_options);
 
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
            return view('crm.crud.invoices.index', compact('invoices', 'chart1', 'chart2', 'chart3', 'invoiceTypeAnalytics', 'invoiceStatusAnalytics'));
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
            $invoiceTypes = InvoiceType::all();
            $leads = Lead::all();
            $invoiceStatuses = InvoiceStatus::all();
            return view('crm.crud.invoices.create', compact('leads', 'invoiceTypes', 'invoiceStatuses'));
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
            'invoice_type_id' => 'required|exists:invoice_types,id',
            'value' => 'required|numeric',
            'attachments' => 'nullable|array|max:5', 
            'attachments.*' => 'mimes:jpg,jpeg,png,pdf|max:2048', 
            'lead_id' => 'nullable|exists:leads,id', 
            'invoice_status_id' => 'required|exists:invoice_statuses,id', 
        ]);

        $data = $request->except('attachments');

        if ($request->hasFile('attachments')) {
            $attachments = [];
            foreach ($request->file('attachments') as $attachment) {
                $extension = $attachment->getClientOriginalExtension();
                $filename = $request->invoice_type_id . '_' . uniqid() . '.' . $extension;
                $attachment->storeAs('public/invoices', $filename);
                $attachments[] = 'invoices/' . $filename; // Save the attachment path in 'invoices' folder
            }
            $data['attachments'] = $attachments;
        }

        Invoice::create($data);
        notify()->success('Invoice Created');
        return redirect($this->previousUrl);
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
            $leads = Lead::all();
            $invoiceTypes = InvoiceType::all();
            $invoiceStatuses = InvoiceStatus::all();
            return view('crm.crud.invoices.edit', compact('leads', 'invoice', 'invoiceTypes', 'invoiceStatuses'));
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'invoice_type_id' => 'required|exists:invoice_types,id',
            'value' => 'required|numeric',
            'attachments' => 'nullable|array|max:5', 
            'attachments.*' => 'mimes:jpg,jpeg,png,pdf|max:2048', 
            'lead_id' => 'nullable|exists:leads,id', 
            'invoice_status_id' => 'required|exists:invoice_statuses,id', 
        ]);

        $data = $request->except('attachments');

        if ($request->hasFile('attachments')) {
            $attachments = [];
            foreach ($request->file('attachments') as $attachment) {
                $extension = $attachment->getClientOriginalExtension();
                $filename = $request->invoice_type_id . '_' . uniqid() . '.' . $extension;
                $attachment->storeAs('public/invoices', $filename);
                $attachments[] = 'invoices/' . $filename; 
            }
            $data['attachments'] = $attachments;
        }

        $invoice->update($data);
        notify()->success('Invoice Updated');
        return redirect($this->previousUrl);
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
