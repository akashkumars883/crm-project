<?php

namespace App\Models;

use App\Traits\BelongsToCompany;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class Project extends Model
{
    use BelongsToCompany;

    use HasFactory, AuditableTrait;

    protected $fillable = [
        'customer_id',
        'project_type_id',
        'project_status_id',
        'assigned_to',
        'name',
        'description',
        'start_date',
        'end_date',
        'total_area',
        'estimated_cost',
        'final_cost',
        'notes',
        'progress_percent',
        'labor_cost',
        'previous_leftover_material_cost',
        'administrative_cost',
        'invoice_value',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_area' => 'decimal:2',
        'estimated_cost' => 'decimal:2',
        'final_cost' => 'decimal:2',
        'progress_percent' => 'decimal:2',
        'labor_cost' => 'decimal:2',
        'previous_leftover_material_cost' => 'decimal:2',
        'administrative_cost' => 'decimal:2',
        'invoice_value' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class);
    }

    public function projectStatus()
    {
        return $this->belongsTo(ProjectStatus::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function attendance()
    {
        return $this->hasMany(AttendanceRecord::class);
    }
}
