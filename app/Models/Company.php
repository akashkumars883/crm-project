<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function subscription()
    {
        return $this->hasOne(\App\Models\Subscription::class)->latestOfMany();
    }

    public function activeSubscription()
    {
        return $this->hasOne(\App\Models\Subscription::class)->where('status', 'active')->where(function ($query) {
            $query->whereNull('ends_at')->orWhere('ends_at', '>=', now());
        })->latestOfMany();
    }

    public function hasReachedLimit($resourceType)
    {
        $sub = $this->activeSubscription;
        
        // If no active subscription, apply strict defaults or allow unlimited for backwards compatibility
        // Let's enforce a default "Free" tier limits if no subscription
        $limit = 10; // default for customers
        if ($resourceType === 'users') $limit = 1;
        if ($resourceType === 'projects') $limit = 5;

        if ($sub && $sub->plan) {
            if ($resourceType === 'users') $limit = $sub->plan->max_users;
            if ($resourceType === 'customers') $limit = $sub->plan->max_customers;
            if ($resourceType === 'projects') $limit = $sub->plan->max_projects;
        }

        $currentCount = 0;
        if ($resourceType === 'users') {
            $currentCount = \App\Models\User::where('company_id', $this->id)->count();
        } elseif ($resourceType === 'customers') {
            $currentCount = \App\Models\Customer::count(); // BelongsToCompany handles where company_id
        } elseif ($resourceType === 'projects') {
            $currentCount = \App\Models\Project::count(); // BelongsToCompany handles where company_id
        }

        return $currentCount >= $limit;
    }
}
