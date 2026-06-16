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
}
