<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class ContactLanguage extends Model
{
    use HasFactory, AuditableTrait;

    protected $fillable = ['name'];

    public function leads()
    {
        return $this->hasMany(Lead::class, 'contact_language_id');
    }
}
