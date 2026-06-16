<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;
use Illuminate\Support\Facades\Auth;

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
        'assignee_id',
    ];

    public function leadSource()
    {
        return $this->belongsTo(LeadSource::class, 'lead_source_id');
    }

    public function leadStatus()
    {
        return $this->belongsTo(LeadStatus::class, 'lead_status_id');
    }

    public function contactMethod()
    {
        return $this->belongsTo(ContactMethod::class, 'contact_method_id');
    }

    public function contactLanguage()
    {
        return $this->belongsTo(ContactLanguage::class, 'contact_language_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'lead_id');
    }
}
