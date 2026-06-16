<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class Payment extends Model
{
    use HasFactory, AuditableTrait;

    protected $fillable = [
        'reference',
        'payment_method_id',
        'payment_status_id',
        'customer_id',
        'project_id',
        'amount',
        'notes'
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function paymentStatus()
    {
        return $this->belongsTo(PaymentStatus::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
