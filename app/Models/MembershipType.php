<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'price'
    ];

    public function package()
    {
        return $this->hasMany(Package::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
