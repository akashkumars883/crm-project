<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class Customer extends Model
{
    use HasFactory, AuditableTrait;

    protected $fillable = [
        'lead_id',
        'user_id',
        'phone',
        'alternate_phone',
        'address',
        'city',
        'state',
        'zip',
        'company_name',
        'gstin',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'customer_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'lead_id', 'lead_id');
    }
}
