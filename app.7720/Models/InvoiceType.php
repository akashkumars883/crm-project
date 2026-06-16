<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class InvoiceType extends Model
{
    use HasFactory, AuditableTrait;

    protected $fillable = ['name'];

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'invoice_type_id');
    }
}
