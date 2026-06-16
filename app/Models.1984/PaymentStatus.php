<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class PaymentStatus extends Model
{
    use HasFactory, AuditableTrait;

    protected $fillable = ['name'];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
