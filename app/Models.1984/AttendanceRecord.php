<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;
use Illuminate\Support\Carbon;

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

    public static function getAttendanceCountsForToday()
    {
        $today = Carbon::today();

        $attendanceRecords = self::whereDate('date', $today)->get();

        // Initialize arrays to store counts
        $attendanceTypeCounts = [];
        $attendanceStatusCounts = [];

        foreach ($attendanceRecords as $record) {
            $attendanceType = $record->attendanceType->name;
            $attendanceStatus = $record->attendanceStatus->name;

            // Count attendanceType
            if (!isset($attendanceTypeCounts[$attendanceType])) {
                $attendanceTypeCounts[$attendanceType] = 0;
            }
            $attendanceTypeCounts[$attendanceType]++;

            // Count attendanceStatus
            if (!isset($attendanceStatusCounts[$attendanceStatus])) {
                $attendanceStatusCounts[$attendanceStatus] = 0;
            }
            $attendanceStatusCounts[$attendanceStatus]++;
        }

        return [
            'attendanceTypeCounts' => $attendanceTypeCounts,
            'attendanceStatusCounts' => $attendanceStatusCounts,
        ];
    }

}
