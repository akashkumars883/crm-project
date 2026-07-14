<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToCompany;

class Task extends Model
{
    use HasFactory, BelongsToCompany;

    protected $fillable = [
        'company_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'assigned_to'
    ];

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
