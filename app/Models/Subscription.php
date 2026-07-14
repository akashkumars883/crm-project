<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'subscription_plan_id',
        'status',
        'payment_method',
        'transaction_id',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class);
    }

    public function plan()
    {
        return $this->belongsTo(\App\Models\SubscriptionPlan::class, 'subscription_plan_id');
    }
}
