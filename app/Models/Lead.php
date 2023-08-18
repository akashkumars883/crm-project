<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class Lead extends Model
{
    use HasFactory, AuditableTrait;

    protected $fillable = [
        'lead_source_id',
        'lead_status_id',
        'name',
        'phone',
        'email',
        'address',
        'city',
        'state',
        'zip',
        'notes',
        'contact_method_id',
        'contact_language_id',
        'assignedTo',
        'user_id',
    ];

    public function leadSource()
    {
        return $this->belongsTo(LeadSource::class, 'lead_source_id');
    }

    public function leadStatus()
    {
        return $this->belongsTo(LeadStatus::class, 'lead_status_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
