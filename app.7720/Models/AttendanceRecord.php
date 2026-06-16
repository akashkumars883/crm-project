<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class AttendanceRecord extends Model
{
    use HasFactory, AuditableTrait;

    protected $fillable = [
        'employee_id',
        'project_id',
        'date',
        'attendance_type_id',
        'attendance_status_id',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function attendanceStatus()
    {
        return $this->belongsTo(AttendanceStatus::class, 'attendance_status_id');
    }

    public function attendanceType()
    {
        return $this->belongsTo(AttendanceType::class, 'attendance_type_id');
    }
}
