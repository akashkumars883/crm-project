<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class Invoice extends Model
{
    use HasFactory, AuditableTrait;

    protected $fillable = [
        'lead_id',
        'is_recurring',
        'recurring_interval',
        'next_invoice_date',
        'invoice_type_id',
        'invoice_status_id',
        'value',
        'attachments',
        'invoice_number',
        'invoice_date',
        'bill_to_name',
        'bill_to_gstin',
        'bill_to_address',
        'bill_to_city',
        'bill_to_state',
        'bill_to_pincode',
        'work_address',
        'subtotal',
        'discount',
        'igst_percent',
        'igst_amount',
        'shipping',
        'balance_due',
        'remarks',
        'bank_name',
        'bank_account_name',
        'bank_account_no',
        'bank_branch',
        'bank_ifsc',
    ];

    protected $casts = [
        'attachments' => 'array',
        'invoice_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'igst_percent' => 'decimal:2',
        'igst_amount' => 'decimal:2',
        'shipping' => 'decimal:2',
        'balance_due' => 'decimal:2',
        'value' => 'decimal:2',
    ];

    public function invoiceType()
    {
        return $this->belongsTo(InvoiceType::class, 'invoice_type_id');
    }

    public function invoiceStatus()
    {
        return $this->belongsTo(InvoiceStatus::class, 'invoice_status_id');
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
