<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class Inventory extends Model
{
    use HasFactory, AuditableTrait;

    protected $fillable =[
        'inventory_status_id',
        'inventory_type_id',
        'vendor_id',
        'title',
        'description',
        'cost',
    ];

    public function inventoryType()
    {
        return $this->belongsTo(InventoryType::class, 'inventory_type_id');
    }

    public function inventoryStatus()
    {
        return $this->belongsTo(InventoryStatus::class, 'inventory_status_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}
