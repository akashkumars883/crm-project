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
        'location_name',
        'latitude',
        'longitude',
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

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_project');
    }

    // Custom methods to calculate values
    public function totalLabor()
    {
        return $this->attendance
            ->where('project_id', $this->id)
            ->pluck('employee_id')
            ->unique()
            ->count();
    }

    public function totalLaborCost()
    {
        $totalEmployees = $this->totalLabor(); // Total number of employees
        $laborCostPerDay = $this->labor_cost; // Labor cost per day from the project model
        $totalDays = $this->attendance->count(); // Total number of attendance records for the project

        // Calculate cumulative labor cost
        $cumulativeLaborCostPerDay = $totalEmployees * $laborCostPerDay * $totalDays;
        $cumulativeLaborCost = $cumulativeLaborCostPerDay * $totalDays;
        return $cumulativeLaborCost;
    }

    public function totalMaterial()
    {
        return $this->inventories->count();
    }

    public function totalMaterialCost()
    {
        $previousLeftoverMaterial = $this->previous_leftover_material_cost ?? 0;
        $totalMaterialPurchased = $this->inventories->sum('cost');

        return $previousLeftoverMaterial + $totalMaterialPurchased;
    }

    public function administrativeCost()
    {
        return $this->administrative_cost ?? 0;
    }

    public function totalCostIncurred()
    {
        $totalLaborCost = $this->totalLaborCost();
        $totalMaterialCost = $this->totalMaterialCost();
        $miscellaneousExpenses = $this->bills->sum('amount');
        $administrativeCost = $this->administrativeCost();

        return $totalLaborCost + $totalMaterialCost + $miscellaneousExpenses + $administrativeCost;
    }

    public function result()
    {
        $invoiceValue = $this->invoice_value ?? 0;
        $totalCostIncurred = $this->totalCostIncurred();

        $profitLossValue = $invoiceValue - $totalCostIncurred;
        $profitLossPercentage = $invoiceValue > 0 ? ($profitLossValue / $invoiceValue) * 100 : 0;

        return [
            'profitLossValue' => $profitLossValue,
            'profitLossPercentage' => $profitLossPercentage,
        ];
    }
}
