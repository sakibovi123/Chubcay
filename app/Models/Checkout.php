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
        "card_number",
        "cvc",
        "expiry",
        "total",
        "tax",
        "grand_total",
        "package_id",
        "user_id"
    ];


    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
