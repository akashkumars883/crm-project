<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class AttendanceStatus extends Model
{
    use HasFactory, AuditableTrait;

    protected $fillable = ['name'];

    public function attendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class, 'attendance_status_id');
    }
}
