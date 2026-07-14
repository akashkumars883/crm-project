<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'max_users',
        'max_customers',
        'max_projects',
        'features',
        'is_active',
    ];
    
    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
    ];
}
