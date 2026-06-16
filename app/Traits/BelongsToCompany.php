<?php

namespace App\Traits;

use App\Scopes\CompanyScope;
use Illuminate\Support\Facades\Auth;

trait BelongsToCompany
{
    /**
     * The "booted" method of the trait.
     */
    protected static function bootBelongsToCompany(): void
    {
        // Add the global scope to filter queries by company_id
        static::addGlobalScope(new CompanyScope);

        // Automatically set the company_id when creating a new record
        static::creating(function ($model) {
            if (Auth::check() && Auth::user()->company_id && empty($model->company_id)) {
                $model->company_id = Auth::user()->company_id;
            }
        });
    }

    /**
     * Relationship to the Company model.
     */
    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class);
    }
}
