<?php

namespace App\Models;

use App\Traits\BelongsToCompany;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class Vendor extends Model
{
    use BelongsToCompany;

    use HasFactory, AuditableTrait;

    protected $fillable = [
        'vendor_status_id',
        'vendor_type_id',
        'name',
        'phone',
        'email',
        'address',
    ];

    public function vendorType()
    {
        return $this->belongsTo(VendorType::class, 'vendor_type_id');
    }

    public function vendorStatus()
    {
        return $this->belongsTo(VendorStatus::class, 'vendor_status_id');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function bills()
    {
        return $this->hasManyThrough(Bill::class, Inventory::class);
    }
}
