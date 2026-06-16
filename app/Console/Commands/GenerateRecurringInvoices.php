<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceGeneratedMail;

class GenerateRecurringInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-recurring-invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new invoices for recurring ones that are due today.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today()->format('Y-m-d');
        
        $dueInvoices = Invoice::with('items')
            ->where('is_recurring', true)
            ->whereDate('next_invoice_date', '<=', $today)
            ->get();

        $this->info("Found " . $dueInvoices->count() . " recurring invoices due for generation.");

        foreach ($dueInvoices as $invoice) {
            DB::beginTransaction();
            try {
                // Generate new Tax Invoice number
                $year = date('y');
                $nextNumber = Invoice::whereYear('created_at', date('Y'))->count() + 1;
                $invoiceNumber = 'HG/' . $year . '-' . substr(date('y') + 1, -2) . '/' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

                // Replicate the invoice
                $newInvoice = $invoice->replicate();
                $newInvoice->invoice_number = $invoiceNumber;
                $newInvoice->invoice_date = $today;
                $newInvoice->due_date = $today;
                $newInvoice->created_at = now();
                $newInvoice->updated_at = now();
                
                // Update next invoice date for the newly created invoice to maintain the recurring cycle
                if ($newInvoice->recurring_interval === 'monthly') {
                    $newInvoice->next_invoice_date = Carbon::parse($today)->addMonth();
                } elseif ($newInvoice->recurring_interval === 'yearly') {
                    $newInvoice->next_invoice_date = Carbon::parse($today)->addYear();
                }

                $newInvoice->save();

                // Replicate items
                foreach ($invoice->items as $item) {
                    $newItem = $item->replicate();
                    $newItem->invoice_id = $newInvoice->id;
                    $newItem->save();
                }

                // Update the old invoice so it stops recurring (the new one takes over)
                $invoice->is_recurring = false;
                $invoice->next_invoice_date = null;
                $invoice->save();

                DB::commit();

                // Send Email Notification
                if ($newInvoice->lead && $newInvoice->lead->email) {
                    Mail::to($newInvoice->lead->email)->queue(new InvoiceGeneratedMail($newInvoice));
                }

                $this->info("Generated invoice {$invoiceNumber} from old invoice {$invoice->invoice_number}");
            } catch (\Exception $e) {
                DB::rollback();
                $this->error("Failed to generate recurring invoice for {$invoice->invoice_number}: " . $e->getMessage());
            }
        }
    }
}
