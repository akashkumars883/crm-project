<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class AttachmentType extends Model
{
    use HasFactory, AuditableTrait;

    protected $fillable = ['name'];

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'attachment_type_id');
    }
}
