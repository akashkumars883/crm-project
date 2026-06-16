<?php

namespace App\Models;

use App\Traits\BelongsToCompany;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class Employee extends Model
{
    use BelongsToCompany;

    use HasFactory, AuditableTrait;

    protected $fillable = [
        'emp_id',
        'employee_type_id',
        'blood_group_id',
        'name',
        'phone',
        'email',
        'gender_id',
        'blood_group_id',
        'date_of_birth',
        'address',
        'joining_date',
        'department_id',
        'designation_id',
        'skill_paint_id',
        'skill_polish_id',
        'salary',
        'photograph',
        'pan',
        'aadhaar',
    ];

    public function employeeType()
    {
        return $this->belongsTo(EmployeeType::class, 'employee_type_id');
    }

    public function bloodGroup()
    {
        return $this->belongsTo(BloodGroup::class, 'blood_group_id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function skillPaint()
    {
        return $this->belongsTo(Skill::class, 'skill_paint_id');
    }

    public function skillPolish()
    {
        return $this->belongsTo(Skill::class, 'skill_polish_id');
    }

    public function employeeBankAccount()
    {
        return $this->hasOne(EmployeeBankAccount::class, 'emp_id', 'id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function attendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public function employeeUser()
    {
        return $this->hasOne(EmployeeUser::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}
