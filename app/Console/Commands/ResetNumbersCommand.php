<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;
use App\Models\Bill;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class ResetNumbersCommand extends Command
{
    protected $signature = 'crm:reset-numbers';
    protected $description = 'Reset invoice, quotation, bill, and payment numbers starting from 1';

    public function handle()
    {
        $this->info('Resetting numbers starting from 1...');

        DB::beginTransaction();
        try {
            $year = date('y');
            $nextYear = substr(date('y') + 1, -2);
            $financialYear = $year . '-' . $nextYear;

            // Invoices & Quotations
            $invCounter = 1;
            $invoices = Invoice::orderBy('id', 'asc')->get();
            foreach ($invoices as $inv) {
                $prefix = ($inv->invoice_type_id == 2) ? 'QTN/' : 'HG/';
                $newNumber = $prefix . $financialYear . '/' . str_pad($invCounter++, 3, '0', STR_PAD_LEFT);
                $inv->invoice_number = $newNumber;
                $inv->save();
                $this->info("Invoice #{$inv->id} updated to {$newNumber}");
            }

            // Bills
            $billCounter = 1;
            $bills = Bill::orderBy('id', 'asc')->get();
            foreach ($bills as $bill) {
                $newRef = 'BILL-' . str_pad($billCounter++, 4, '0', STR_PAD_LEFT);
                $bill->reference = $newRef;
                $bill->save();
                $this->info("Bill #{$bill->id} updated to {$newRef}");
            }

            // Payments
            $payCounter = 1;
            $payments = Payment::orderBy('id', 'asc')->get();
            foreach ($payments as $pay) {
                $newRef = 'PAY-' . str_pad($payCounter++, 4, '0', STR_PAD_LEFT);
                $pay->reference = $newRef;
                $pay->save();
                $this->info("Payment #{$pay->id} updated to {$newRef}");
            }

            DB::commit();
            $this->info('SUCCESS: All numbers reset cleanly starting from 001.');
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error('ERROR: ' . $e->getMessage());
        }
    }
}
