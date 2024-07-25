<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\Package;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Rules\MonthYear;

class CheckoutController extends Controller
{
    public function handleCheckout( Request $request ) 
    {
        try {
            $package = Package::where("id", $request->get('package_id'))->first();
            
            // validation
            $request->validate([
                "first_name" => "required|string",
                "last_name" => "required|string",
                "email" => "required|email",
            ]);

            $data = $request->all();

            if ( $package ) {
                $checkout = Checkout::create($data);
                $checkout->total = $checkout->package->price;
                
                // $checkout->total = $checkout->package_id->price;
                if( $checkout->tax ) 
                {
                    $checkout->grand_total += $checkout->total + (100 / $checkout->tax);
                }
                $checkout->grand_total += $checkout->total;
                dd($checkout->grand_total);
                $checkout->save();


                return response()->json([
                    "success" => true,
                    "trx_id" => $checkout->trx_id
                ]);
            }
        } catch ( Exception $e ) {
            return response()->json([
                "success" => false,
                "error" => $e->getMessage()
            ]);
        }
    }
}



// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\View;
// use Shift4\Gateway as Shift4Gateway;
// use Shift4\CheckoutRequest;

// class ExamplesController extends Controller
// {
//     private const PRIVATE_KEY = 'sk_test_uEasbq0gr30puLspIcRH0FQD';

//     public function checkout()
//     {
//         try {
//             $shift4Gateway = new Shift4Gateway(self::PRIVATE_KEY);
//             $checkoutRequest = new CheckoutRequest();
//             $checkoutRequest->charge(2499, 'USD');

//             $signedCheckoutRequest = $shift4Gateway->signCheckoutRequest($checkoutRequest);

//             return view('examples.checkout', ['signedCheckoutRequest' => $signedCheckoutRequest]);
//         } catch (\Exception $e) {
//             return back()->withErrors(['error' => $e->getMessage()]);
//         }
//     }

//     public function checkoutSubmit(Request $request)
//     {
//         $shift4ChargeId = $request->input('shift4ChargeId');

//         return view('examples.checkout', ['chargeId' => $shift4ChargeId]);
//     }
// }
