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
        'duration',
        'duration_title',
        'membership_type_id'
    ];

    protected $casts = [
        'features' => 'array'
    ];

    public function package_expirations() {
        return $this->hasMany(PackageExpiration::class);
    }

    public function checkouts()
    {
        return $this->hasMany(Checkout::class);
    }

    public function membershiptype()
    {
        return $this->belongsTo(MembershipType::class, 'membership_type_id');
    }


}
