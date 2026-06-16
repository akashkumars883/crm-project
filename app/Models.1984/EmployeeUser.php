<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class EmployeeUser extends Model
{
    use HasFactory, AuditableTrait;

    protected $table = 'employee_user';

    protected $fillable = [
        'employee_id',
        'user_id',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
