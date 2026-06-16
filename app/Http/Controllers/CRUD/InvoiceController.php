<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceType;
use App\Models\InvoiceStatus;
use App\Models\Lead;
use App\Models\Customer;
use App\Mail\InvoiceGeneratedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    protected $previousUrl;

    public function __construct()
    {
        $this->previousUrl = URL::previous();
    }

    public function index(Request $request)
    {
        $searchQuery = $request->input('search');
        $invoicesQuery = Invoice::with(['items', 'lead', 'invoiceType', 'invoiceStatus']);

        if ($searchQuery) {
            $invoicesQuery->where(function ($query) use ($searchQuery) {
                $query->where('invoice_number', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('bill_to_name', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhereHas('lead', function ($q) use ($searchQuery) {
                        $q->where('name', 'LIKE', '%' . $searchQuery . '%');
                    });
            });
        }

        $invoices = $invoicesQuery->latest()->paginate(15);
        return view('crm.crud.invoices.index', compact('invoices'));
    }

    public function create(Request $request)
    {
        $invoiceTypes = InvoiceType::all();
        $invoiceStatuses = InvoiceStatus::all();
        $leads = Lead::all();
        $customers = Customer::with('lead')->get();
        $presetLeadId = $request->get('lead_id');

        return view('crm.crud.invoices.create', compact(
            'invoiceTypes', 'invoiceStatuses', 'leads', 'customers', 'presetLeadId'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_date' => 'required|date',
            'lead_id' => 'required|exists:leads,id',
            'bill_to_name' => 'required|string|max:255',
            'bill_to_gstin' => 'nullable|string|max:20',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.hsn_sac' => 'nullable|string',
            'items.*.quantity' => 'nullable|numeric',
            'items.*.price' => 'nullable|numeric',
        ]);

        DB::beginTransaction();
        try {
            // Generate invoice number
            $year = date('y'); // last 2 digits
            $nextNumber = Invoice::whereYear('created_at', date('Y'))->count() + 1;
            $invoiceNumber = 'HG/' . $year . '-' . substr(date('y') + 1, -2) . '/' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // Calculate totals
            $subtotal = 0;
            foreach ($request->items as $item) {
                $qty = isset($item['quantity']) ? (float)$item['quantity'] : 0;
                $price = isset($item['price']) ? (float)$item['price'] : 0;
                $subtotal += $qty * $price;
            }

            $discount = (float)$request->input('discount', 0);
            $taxable = $subtotal - $discount;
            $igstPercent = (float)$request->input('igst_percent', 18);
            $igstAmount = round($taxable * $igstPercent / 100, 2);
            $shipping = (float)$request->input('shipping', 0);
            $balanceDue = $taxable + $igstAmount + $shipping;

            // Create invoice
            $invoice = Invoice::create([
                'invoice_number' => $invoiceNumber,
                'invoice_date' => $request->invoice_date,
                'lead_id' => $request->lead_id,
                'invoice_type_id' => $request->input('invoice_type_id', 1),
                'invoice_status_id' => $request->input('invoice_status_id', 1),
                'value' => $balanceDue,
                'bill_to_name' => $request->bill_to_name,
                'bill_to_gstin' => $request->bill_to_gstin,
                'bill_to_address' => $request->bill_to_address,
                'bill_to_city' => $request->bill_to_city,
                'bill_to_state' => $request->bill_to_state,
                'bill_to_pincode' => $request->bill_to_pincode,
                'work_address' => $request->work_address,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'igst_percent' => $igstPercent,
                'igst_amount' => $igstAmount,
                'shipping' => $shipping,
                'balance_due' => $balanceDue,
                'remarks' => $request->remarks,
                'bank_name' => $request->input('bank_name', 'IDFC Bank'),
                'bank_account_name' => $request->input('bank_account_name', 'Home Glazer Solutions Private Limited'),
                'bank_account_no' => $request->input('bank_account_no', '10183062134'),
                'bank_branch' => $request->input('bank_branch', 'Udyog Vihar, Gurgaon'),
                'bank_ifsc' => $request->input('bank_ifsc', 'IDFB0021014'),
                'is_recurring' => $request->has('is_recurring'),
                'recurring_interval' => $request->has('is_recurring') ? $request->recurring_interval : null,
                'next_invoice_date' => $request->has('is_recurring') ? 
                    ($request->recurring_interval === 'yearly' ? \Carbon\Carbon::parse($request->invoice_date)->addYear() : \Carbon\Carbon::parse($request->invoice_date)->addMonth()) 
                    : null,
            ]);

            // Create items
            foreach ($request->items as $index => $item) {
                $qty = isset($item['quantity']) ? (float)$item['quantity'] : 0;
                $price = isset($item['price']) ? (float)$item['price'] : 0;
                $total = $qty * $price;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'sr_no' => $index + 1,
                    'description' => $item['description'],
                    'hsn_sac' => $item['hsn_sac'] ?? '995472',
                    'quantity_type' => $item['quantity_type'] ?? 'number',
                    'quantity' => $qty,
                    'price' => $price,
                    'total' => $total,
                ]);
            }

            DB::commit();

            // Send Email Notification
            if ($invoice->lead && $invoice->lead->email) {
                Mail::to($invoice->lead->email)->queue(new InvoiceGeneratedMail($invoice));
            }

            notify()->success('Tax Invoice ' . $invoiceNumber . ' created successfully');
            return redirect()->route('invoices.show', $invoice->id);
        } catch (\Exception $e) {
            DB::rollback();
            notify()->error('Error creating invoice: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('items', 'lead', 'invoiceType', 'invoiceStatus');
        return view('crm.crud.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $invoice->load('items');
        $invoiceTypes = InvoiceType::all();
        $invoiceStatuses = InvoiceStatus::all();
        $leads = Lead::all();
        $customers = Customer::with('lead')->get();
        return view('crm.crud.invoices.edit', compact(
            'invoice', 'invoiceTypes', 'invoiceStatuses', 'leads', 'customers'
        ));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'invoice_date' => 'required|date',
            'lead_id' => 'required|exists:leads,id',
            'bill_to_name' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            // Calculate totals
            $subtotal = 0;
            foreach ($request->items as $item) {
                $qty = isset($item['quantity']) ? (float)$item['quantity'] : 0;
                $price = isset($item['price']) ? (float)$item['price'] : 0;
                $subtotal += $qty * $price;
            }

            $discount = (float)$request->input('discount', 0);
            $taxable = $subtotal - $discount;
            $igstPercent = (float)$request->input('igst_percent', 18);
            $igstAmount = round($taxable * $igstPercent / 100, 2);
            $shipping = (float)$request->input('shipping', 0);
            $balanceDue = $taxable + $igstAmount + $shipping;

            $invoice->update([
                'invoice_date' => $request->invoice_date,
                'lead_id' => $request->lead_id,
                'invoice_type_id' => $request->input('invoice_type_id', 1),
                'invoice_status_id' => $request->input('invoice_status_id', 1),
                'value' => $balanceDue,
                'bill_to_name' => $request->bill_to_name,
                'bill_to_gstin' => $request->bill_to_gstin,
                'bill_to_address' => $request->bill_to_address,
                'bill_to_city' => $request->bill_to_city,
                'bill_to_state' => $request->bill_to_state,
                'bill_to_pincode' => $request->bill_to_pincode,
                'work_address' => $request->work_address,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'igst_percent' => $igstPercent,
                'igst_amount' => $igstAmount,
                'shipping' => $shipping,
                'balance_due' => $balanceDue,
                'remarks' => $request->remarks,
                'bank_name' => $request->bank_name,
                'bank_account_name' => $request->bank_account_name,
                'bank_account_no' => $request->bank_account_no,
                'bank_branch' => $request->bank_branch,
                'bank_ifsc' => $request->bank_ifsc,
                'is_recurring' => $request->has('is_recurring'),
                'recurring_interval' => $request->has('is_recurring') ? $request->recurring_interval : null,
                'next_invoice_date' => $request->has('is_recurring') ? 
                    ($request->recurring_interval === 'yearly' ? \Carbon\Carbon::parse($request->invoice_date)->addYear() : \Carbon\Carbon::parse($request->invoice_date)->addMonth()) 
                    : null,
            ]);

            // Delete old items and create new
            $invoice->items()->delete();
            foreach ($request->items as $index => $item) {
                $qty = isset($item['quantity']) ? (float)$item['quantity'] : 0;
                $price = isset($item['price']) ? (float)$item['price'] : 0;
                $total = $qty * $price;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'sr_no' => $index + 1,
                    'description' => $item['description'],
                    'hsn_sac' => $item['hsn_sac'] ?? '995472',
                    'quantity_type' => $item['quantity_type'] ?? 'number',
                    'quantity' => $qty,
                    'price' => $price,
                    'total' => $total,
                ]);
            }

            DB::commit();
            notify()->success('Invoice updated successfully');
            return redirect()->route('invoices.show', $invoice->id);
        } catch (\Exception $e) {
            DB::rollback();
            notify()->error('Error updating invoice: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        notify()->success('Invoice deleted successfully');
        return redirect()->route('invoices.index');
    }

    public function print(Invoice $invoice)
    {
        $invoice->load('items', 'lead');
        return view('crm.crud.invoices.print', compact('invoice'));
    }

    public function convertProforma(Invoice $invoice)
    {
        if ($invoice->invoice_type_id != 2) {
            notify()->error('Only Proforma Invoices can be converted.');
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            // Generate new Tax Invoice number
            $year = date('y'); // last 2 digits
            $nextNumber = Invoice::whereYear('created_at', date('Y'))->count() + 1;
            $invoiceNumber = 'HG/' . $year . '-' . substr(date('y') + 1, -2) . '/' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // Replicate the invoice
            $newInvoice = $invoice->replicate();
            $newInvoice->invoice_type_id = 11; // Tax Invoice
            $newInvoice->invoice_number = $invoiceNumber;
            $newInvoice->invoice_date = now()->format('Y-m-d');
            $newInvoice->created_at = now();
            $newInvoice->updated_at = now();
            $newInvoice->save();

            // Replicate items
            foreach ($invoice->items as $item) {
                $newItem = $item->replicate();
                $newItem->invoice_id = $newInvoice->id;
                $newItem->save();
            }

            DB::commit();

            // Send Email Notification
            if ($newInvoice->lead && $newInvoice->lead->email) {
                Mail::to($newInvoice->lead->email)->queue(new InvoiceGeneratedMail($newInvoice));
            }

            notify()->success('Proforma successfully converted to Tax Invoice ' . $invoiceNumber);
            return redirect()->route('invoices.show', $newInvoice->id);
        } catch (\Exception $e) {
            DB::rollback();
            notify()->error('Error converting invoice: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
