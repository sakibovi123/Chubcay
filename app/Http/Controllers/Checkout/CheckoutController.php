<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\Package;
use App\Services\Shift4Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Rules\MonthYear;
use Illuminate\Support\Facades\Log;
use Shift4\Shift4Gateway;
use Shift4\Request\CheckoutRequest;
use Shift4\Request\CheckoutRequestCharge;
use Inertia\Inertia;


class CheckoutController extends Controller
{
    protected $shift4Service;

    public function __construct(Shift4Service $shift4Service)
    {
        $this->shift4Service = $shift4Service;
    }

    public function handleCheckout( Request $request ) 
    {
        
        try {

            $currency = 'USD';
            // $package = Package::where("id", $request->get('package_id'))->first();
            $package = Package::where("id", 2)->first();
            // validation
            // $request->validate([
            //     "first_name" => "required|string",
            //     "last_name" => "required|string",
            //     "email" => "required|email",
            // ]);

            // $data = $request->all();
            $data = [
                "first_name" => "John",
                "last_name" => "die",
                "email" => "john@example.com",
                "package_id" => $package->id,
                "user_id" => 1,
            ];
            dd($data);
            if ( $package ) {
                $checkout = Checkout::create($data);
                $checkout->total = $checkout->package->price;

                // dd($checkout->total);
                
                // $checkout->total = $checkout->package_id->price;
                if( $checkout->tax ) 
                {
                    $checkout->grand_total += $checkout->total + 100 / $checkout->tax;
                }
                $checkout->grand_total += $checkout->total;
                // dd($checkout->grand_total);
                $checkout->save();
                
                return redirect(route('home.home'));

            }
            else {
                return response()->json([
                    "success" => false,
                    "error" => "Something went wrong"
                ], 404);
            }
        } catch ( Exception $e ) {
            return response()->json([
                "success" => false,
                "error" => $e->getMessage()
            ]);
        }
    }


}
