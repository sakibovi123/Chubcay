<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    protected $fillable = [
        "trx_id",
        "first_name",
        "last_name",
        "email",
        "phone",
        "total",
        "tax",
        "grand_total",
        "package_id",
        "user_id"
    ];


    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
