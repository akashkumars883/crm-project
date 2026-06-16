<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class Attachment extends Model
{
    use HasFactory, AuditableTrait;

    protected $fillable = [
        'attachment_type_id',
        'project_id',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function attachmentType()
    {
        return $this->belongsTo(AttachmentType::class, 'attachment_type_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
