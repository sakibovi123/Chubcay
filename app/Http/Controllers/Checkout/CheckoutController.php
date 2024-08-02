<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\Package;
use App\Models\PackageExpiration;
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
use Shift4\Exception\Shift4Exception;



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
            $auth = auth()->user();
            $currency = 'USD';
            $package = Package::where("id", $request->get('package_id'))->first();
            // $package = Package::where("id", 2)->first();
            // validation
            $request->validate([
                "first_name" => "required|string",
                "last_name" => "required|string",
                "email" => "required|email",
                "phone" => "required|string",
                // "card_number" => "required|number|max:16",
                // "cvc" => "required|number|max:3"
            ]);
            // dd(auth()->user()->id);
            // $data = $request->all();
            $data = [
                "first_name" => $request->get('first_name'),
                "last_name" => $request->get('last_name'),
                "email" => $request->get('email'),
                "package_id" => $package->id,
                "user_id" => auth()->user()->id, // just testing for now
            ];

            // getting mm and yy
            $mm = $request->get('mm');
            $yy = $request->get('year');

            $expiry = $mm."/".$yy;
            // dd($expiry);
            // dd($data);
            if ( $package ) {
                $checkout = Checkout::create($data);
                $checkout->total = $checkout->package->price;
                
                // $checkout->total = $checkout->package_id->price;
                if( $checkout->tax ) 
                {
                    $checkout->grand_total += $checkout->total + 100 / $checkout->tax;
                }
                $checkout->grand_total += $checkout->total;
                // dd($checkout->grand_total);
                $checkout->save();

                $gateway = new Shift4Gateway(env('SHIFT4_SECRET'));

                $sh_request = [
                    'amount' => $checkout->grand_total,
                    'currency' => 'USD',
                    // 'customerId' => $checkout->user_id,
                    'card' => [
                        'number' => $request->get('card_number'),
                        'expMonth' => $mm,
                        'expYear' => $yy
                    ]
                ];
                // dd("asdasd");
                try{
                    $charge = $gateway->createCharge($sh_request);
                    
                    $chargeId = $charge->getId();
                    
                    if( $charge->getStatus() == "successful" ) {
                        $checkout->status = "Success";
                        $checkout->payment_status = "Paid";
                        $checkout->save();
                        
                        // saving package expiration model
                        // need to check if one already exist then replace the package
                        
                        $existed_package = PackageExpiration::where("user_id", $request->user()->id)
                            ->first();

                        if( !$existed_package )
                        {
                            // dd($checkout->package->duration);
                            $pkg_exp = PackageExpiration::create([
                                "package_id" => $checkout->package->id,
                                "user_id" => auth()->user()->id,
                                "duration" => $checkout->package->duration
                            ]);

                            // dd($pkg_exp->duration);
                        }
                        else
                        {
                            $existed_package->package_id = $checkout->package->id;
                            $existed_package->duration = $checkout->package->duration;

                            $existed_package->save();
                        }
                        
                        return redirect(route('checkout.success'));
                    }
                } catch( Shift4Exception $se ) {
                    $checkout->status = "Cancelled";
                    $checkout->payment_status = "Unpaid";
                    $checkout->save();
                    return Inertia::render("Failed", [
                        "error" => $se->getMessage()
                    ]);
                }
            
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


    public function handleSuccess()
    {
        return Inertia::render("Success");
    }

    public function handleFailed()
    {
        return Inertia::render("Failed");
    }
}
