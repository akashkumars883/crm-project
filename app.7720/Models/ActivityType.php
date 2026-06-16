<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class ActivityType extends Model
{
    use HasFactory, AuditableTrait;

    protected $fillable = ['name'];

    public function activities()
    {
        return $this->hasMany(Activity::class, 'activity_type_id');
    }
}
