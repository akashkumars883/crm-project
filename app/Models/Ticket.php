<?php

namespace App\Models;

use App\Traits\BelongsToCompany;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class Ticket extends Model
{
    use BelongsToCompany;

    use HasFactory, AuditableTrait;

    protected $fillable = [
        'ticket_category_id',
        'priority',
        'subject',
        'message',
        'status',
        'client_id',
        'assigned_to',
    ];

    public function ticketCategory()
    {
        return $this->belongsTo(TicketCategory::class, 'ticket_category_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
