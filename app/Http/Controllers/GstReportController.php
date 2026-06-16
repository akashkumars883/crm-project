<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Expense;
use App\Models\Bill;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class GstReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        // Output Tax (Sales)
        // We calculate IGST as total output tax for simplicity based on the existing invoices schema
        $invoices = Invoice::whereMonth('invoice_date', $month)
            ->whereYear('invoice_date', $year)
            ->get();
            
        $totalSales = $invoices->sum('subtotal');
        $outputTax = $invoices->sum('igst_amount');

        // Input Tax (Expenses + Bills)
        $expenses = Expense::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('status', 'Approved')
            ->get();
            
        $bills = Bill::whereMonth('bill_date', $month)
            ->whereYear('bill_date', $year)
            ->get();

        $inputTaxExpenses = $expenses->sum('tax_amount');
        $inputTaxBills = $bills->sum('tax_amount');
        $totalInputTax = $inputTaxExpenses + $inputTaxBills;

        $netLiability = $outputTax - $totalInputTax;

        return view('crm.gst.dashboard', compact(
            'month', 'year', 'totalSales', 'outputTax', 'totalInputTax', 'netLiability', 'inputTaxExpenses', 'inputTaxBills'
        ));
    }

    public function exportGstr1(Request $request)
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        $invoices = Invoice::with('lead')
            ->whereMonth('invoice_date', $month)
            ->whereYear('invoice_date', $year)
            ->get();

        $filename = "GSTR1_{$year}_{$month}.csv";
        $handle = fopen('php://output', 'w');

        // CSV Headers matching typical GSTR-1 structure
        fputcsv($handle, ['GSTIN/UIN of Recipient', 'Receiver Name', 'Invoice Number', 'Invoice date', 'Invoice Value', 'Place Of Supply', 'Reverse Charge', 'Invoice Type', 'Rate', 'Taxable Value']);

        foreach ($invoices as $invoice) {
            $gstin = $invoice->bill_to_gstin ?? '';
            $type = $gstin ? 'B2B' : 'B2C'; // Basic classification
            $rate = $invoice->igst_percent ?? 18;
            $taxable = $invoice->subtotal - $invoice->discount;
            $pos = $invoice->bill_to_state ?? '06-Haryana'; // Defaulting to HR if empty

            fputcsv($handle, [
                $gstin,
                $invoice->bill_to_name,
                $invoice->invoice_number,
                Carbon::parse($invoice->invoice_date)->format('d-M-y'),
                $invoice->total_amount,
                $pos,
                'N',
                $type,
                $rate,
                $taxable
            ]);
        }

        fclose($handle);

        return Response::make('', 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    public function exportGstr2(Request $request)
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        $expenses = Expense::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('status', 'Approved')
            ->whereNotNull('vendor_gstin')
            ->get();

        $filename = "GSTR2_ITC_{$year}_{$month}.csv";
        $handle = fopen('php://output', 'w');

        fputcsv($handle, ['Vendor GSTIN', 'Category', 'Date', 'Amount (Base)', 'Tax Rate (%)', 'Tax Amount (ITC)']);

        foreach ($expenses as $expense) {
            fputcsv($handle, [
                $expense->vendor_gstin,
                $expense->category,
                Carbon::parse($expense->date)->format('d-M-y'),
                $expense->amount,
                $expense->tax_percent,
                $expense->tax_amount
            ]);
        }

        fclose($handle);

        return Response::make('', 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }
}
