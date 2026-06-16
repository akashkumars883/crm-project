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
        'invoice_type_id',
        'invoice_status_id',
        'value',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
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
        return $this->belongsTo(Lead::class, 'lead_id'); // Added the lead relationship
    }
}
