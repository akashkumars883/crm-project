<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Yajra\Auditable\AuditableTrait;

class LeadStatus extends Model
{
    use HasFactory, AuditableTrait;

    protected $fillable = ['name'];

    public function leads()
    {
        return $this->hasMany(Lead::class, 'lead_status_id');
    }
}
