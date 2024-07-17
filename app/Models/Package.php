<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'sub_title',
        'price',
        'discount',
        'features'
    ];

    protected $casts = [
        'features' => 'array'
    ];
}
