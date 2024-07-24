<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'sub_title',
        'price',
        'discount',
        'features',
        'duration'
    ];

    protected $casts = [
        'features' => 'array'
    ];

    public function package_expirations() {
        return $this->belongsTo(PackageExpiration::class);
    }

    public function checkouts()
    {
        return $this->belongsTo(Checkout::class);
    }
    

}
