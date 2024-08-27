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
        "user_id",
        "payment_status",
        "invoice",
        "payment_option",
        "paid",
        "due"
    ];


    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function packageexpiration()
    {
        return $this->hasMany(PackageExpiration::class);
    }
}
