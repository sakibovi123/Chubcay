<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\Package;
use Exception;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function handleCheckout( Request $request, $package_id ) 
    {
        try {
            $package = Package::where("id", $package_id)->first();
            // validation
            $request->validate([
                "trx_id" => "required|unique",
                "first_name" => "required|string",
                "last_name" => "required|string",
                "email" => "required|email",
                // "phone" => "required"
                "card_number" => "required|string",
                "cvc" => "required|integer",
                "expiry" => "required|date"
            ]);

            if ( $package ) {
                $checkout = Checkout::create($request->all());
                if( $checkout->tax ) 
                {
                    $checkout->grand_total += $checkout->total + $checkout->tax / 100;
                }
            }
        } catch ( Exception $e ) {
            return $e->getMessage();
        }
    }
}
