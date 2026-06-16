<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class Bill extends Model
{
    use HasFactory, AuditableTrait;

    protected $fillable = [
        'bill_type_id',
        'reference',
        'amount',
        'bill_date',
        'due_date',
        'bill_status_id',
        'payment_method_id',
        'project_id',
        'inventory_id',
        'employee_id',
        'notes',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'json',
    ];

    public function billType()
    {
        return $this->belongsTo(BillType::class);
    }

    public function billStatus()
    {
        return $this->belongsTo(BillStatus::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
