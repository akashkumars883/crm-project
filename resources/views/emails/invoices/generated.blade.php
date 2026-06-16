<x-mail::message>
# New Invoice: {{ $invoice->invoice_number }}

Dear {{ $invoice->lead->name ?? 'Customer' }},

A new invoice (**{{ $invoice->invoice_number }}**) has been generated for your account on **{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') }}**.

**Total Amount Due:** {{ get_setting('currency', '₹') }}{{ number_format($invoice->total_amount, 2) }}

Please find your invoice details by clicking the button below, or logging into your client portal.

<x-mail::button :url="route('invoices.show', $invoice->id)">
View Invoice
</x-mail::button>

If you have any questions about this invoice, please reach out to us.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
