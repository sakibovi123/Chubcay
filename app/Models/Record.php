<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'action', 'total_amount', 'paid_amount', 'due_amount'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
