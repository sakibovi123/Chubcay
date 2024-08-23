<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeCheckout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'method', 'check_number', 'card_number', 'total_charge', 'payment_status', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
