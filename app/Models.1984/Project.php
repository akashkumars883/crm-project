<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class Project extends Model
{
    use HasFactory, AuditableTrait;

    protected $fillable = [
        'project_type_id',
        'project_status_id',
        'customer_id',
        'start_date',
        'end_date',
        'assigned_to',
        'labor_cost', 
        'invoiceValue',
        'previousLeftoverMaterialCost',
        'administrativeCost',
    ];

    
    public function projectType()
    {
        return $this->belongsTo(ProjectType::class);
    }

    public function projectStatus()
    {
        return $this->belongsTo(ProjectStatus::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'project_id');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'project_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'project_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function attendance()
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }



    // Custom methods to calculate values
    public function totalLabor()
    {
        return $this->attendance
            ->where('project_id', $this->id) // Replace 'id' with the actual primary key of the project model
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
        $previousLeftoverMaterial = $this->previousLeftoverMaterialCost; // Replace with your actual value
        $totalMaterialPurchased = $this->inventories->sum('cost');

        return $previousLeftoverMaterial + $totalMaterialPurchased;
    }

    public function administrativeCost()
    {
        $administrativeCost = $this->administrativeCost;

        return $administrativeCost;
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
        $invoiceValue = $this->invoiceValue;
        $totalCostIncurred = $this->totalCostIncurred();

        $profitLossValue = $invoiceValue - $totalCostIncurred;
        $profitLossPercentage = ($profitLossValue / $invoiceValue) * 100;

        return [
            'profitLossValue' => $profitLossValue,
            'profitLossPercentage' => $profitLossPercentage,
        ];
    }
}
