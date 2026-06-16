<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class EmployeeType extends Model
{
    use HasFactory, AuditableTrait;

    protected $fillable = ['name'];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'employee_type_id');
    }
}
