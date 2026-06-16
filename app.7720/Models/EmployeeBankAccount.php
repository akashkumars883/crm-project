<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class EmployeeBankAccount extends Model
{
    use HasFactory, AuditableTrait;

    protected $fillable = [
        'emp_id',
        'bank_name',
        'branch',
        'ifsc',
        'account_name',
        'account_number',
        'upi',
        'phonepe',
        'googlepay',
        'paytm',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }
}
