<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class Activity extends Model
{
    use HasFactory, AuditableTrait;

    protected $fillable = ['activity_type_id', 'lead_id', 'customer_id', 'project_id', 'contact_method_id', 'title', 'description'];

    public function activityType()
    {
        return $this->belongsTo(ActivityType::class, 'activity_type_id');
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function contactMethod()
    {
        return $this->belongsTo(ContactMethod::class);
    }
}
