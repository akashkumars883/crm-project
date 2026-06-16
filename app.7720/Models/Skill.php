<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class Skill extends Model
{
    use HasFactory, AuditableTrait;

    protected $fillable = ['name'];
}
