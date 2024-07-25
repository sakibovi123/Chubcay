<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageExpiration extends Model
{
    use HasFactory;

    protected $fillable = [
        "package_id", "user_id", "is_expired"
    ];

    public function packages() {
        return $this->hasMany(Package::class);
    }

    public function users() {
        return $this->hasMany(User::class);
    }
}
