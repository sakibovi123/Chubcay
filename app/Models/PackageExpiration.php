<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageExpiration extends Model
{
    use HasFactory;

    protected $fillable = [
        "package_id", "user_id", "is_expired", "duration", "token"
    ];

    public function package() {
        return $this->belongsTo(Package::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
