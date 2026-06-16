<?php

namespace App\Models;

use App\Traits\BelongsToCompany;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use BelongsToCompany;

    use HasFactory;

    protected $fillable = [
        'date',
        'amount',
        'vendor_gstin',
        'tax_percent',
        'tax_amount',
        'category',
        'description',
        'receipt_path',
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
