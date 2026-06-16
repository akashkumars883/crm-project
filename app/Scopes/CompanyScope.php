<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class CompanyScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // Only apply the scope if a user is authenticated and already resolved
        // auth()->hasUser() prevents infinite recursion during user resolution (unlike Auth::check())
        if (auth()->hasUser()) {
            $user = auth()->user();
            
            // If the user has a company_id, scope the query to that company.
            if ($user->company_id) {
                // If user is super-admin, do not scope (they see everything)
                if (!$user->hasRole('super-admin')) {
                    $builder->where($model->getTable() . '.company_id', $user->company_id);
                }
            }
        }
    }
}
