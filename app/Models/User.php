<?php

namespace App\Models;

use App\Traits\BelongsToCompany;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements LaratrustUser
{
    use BelongsToCompany;

    use HasApiTokens, HasFactory, Notifiable, HasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'phone',
        'dob',
        'address',
        'bank_account_name',
        'bank_account_number',
        'bank_ifsc',
        'bank_name',
        'bank_branch',
        'upi_id',
        'company_id',
    ];

    // protected $dates = ['created_at']; 

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function employeeUser()
    {
        return $this->hasOne(EmployeeUser::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class, 'assignee_id');
    }
}
