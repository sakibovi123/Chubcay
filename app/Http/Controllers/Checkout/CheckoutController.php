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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Shift4\Shift4Gateway;
use Shift4\Request\CheckoutRequest;
use Shift4\Request\CheckoutRequestCharge;
use Inertia\Inertia;
use Shift4\Exception\Shift4Exception;
use Illuminate\Support\Facades\Http;



class CheckoutController extends Controller
{
    protected $shift4Service;

    public function __construct(Shift4Service $shift4Service)
    {
        $this->shift4Service = $shift4Service;
    }

    
public function handleCheckout( Request $request ) 
    {   
        $paid = 0.00;
        $due = 0.00;
        $charge = 0.00;

        try {
            $auth = Auth::user();
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
                "user_id" => $auth->id,
                "invoice" => mt_rand(1, 9999),
                "payment_option" => $request->payment_option
            ];

            // dd($data);

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
                    $checkout->grand_total += $checkout->total
                         + 100 / $checkout->tax;
                }
                $checkout->grand_total += $checkout->total;
                // dd($checkout->grand_total);
                $checkout->save();

                $gateway = new Shift4Gateway(env('SHIFT4_SECRET'));

                // creating customer

                $customerRequest = [
                    'email' => $data['email'],
                ];
                
                $response = Http::withBasicAuth(env('SHIFT4_SECRET'), '')
                    ->asForm()
                    ->post('https://api.shift4.com/customers', $customerRequest);
                
                if( $request->payment_option == 'partial' ) {
                    $charge = $request->amount;
                    $checkout->paid = $charge;
                    $checkout->due = $checkout->grand_total - $charge;

                    $checkout->save();
                    // dd($request->amount);
                }
                else {
                    $charge = $checkout->grand_total;

                    $checkout->paid = $checkout->grand_total;

                    $checkout->due = 0.00;

                    $checkout->save();
                }

                $sh_request = [
                    'amount' => $charge * 100,
                    'currency' => 'USD',
                    // 'customerId' => $checkout->user_id,
                    'card' => [
                        'number' => $request->get('card_number'),
                        'expMonth' => $mm,
                        'expYear' => $yy
                    ],
                    'customerId' => $response['id'],
                    'metadata' =>  [
                        'plan' => $checkout->package->title,
                        'duration' => $checkout->package->duration . 'days'
                    ]
                     
                ];
                // dd($sh_request['amount']);

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
                                "user_id" => $auth->id,
                                "duration" => $checkout->package->duration,
                                "is_active" => true,
                                "checkout_id" => $checkout->id
                            ]);

                            // dd($pkg_exp->duration);
                        }
                        else
                        {
                            $existed_package->package_id = $checkout->package->id;
                            $existed_package->duration = $checkout->package->duration;
                            $existed_package->is_active = true;
                            $existed_package->checkout_id = $checkout->id;
                            $existed_package->save();
                        }

                        // creating plans and subs

                        

                        $planRequest = [
                            'amount' => $checkout->grand_total * 100,
                            'currency' => 'USD',
                            'interval' => 'day',
                            'intervalCount' => $checkout->package->duration,
                            'name' => $checkout->package->duration_title,
                        ];

                        $responsePlan = Http::withBasicAuth(env('SHIFT4_SECRET'), '')
                            ->asForm()
                            ->post('https://api.shift4.com/plans', $planRequest);
                        
                        // processing subscription
                        // dd($responsePlan['id']);
                        $subRequest = [
                            'planId' => $responsePlan['id'],
                            'customerId' => $response['id'],
                        ];

                        $responseSub = Http::withBasicAuth(env('SHIFT4_SECRET'), '')
                            ->asForm()
                            ->post('https://api.shift4.com/subscriptions', $subRequest);

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


    public function edit($checkoutId)
    {
        $checkout = Checkout::findOrFail($checkoutId);
        return view('paymember', [ 'checkout' => $checkout ]);
    }

    public function update(Request $request, $checkoutId) 
    {   
        $charge = 0.00;

        try {
            $auth = Auth::user();
            $currency = 'USD';

            // Fetch the existing Checkout record
            $checkout = Checkout::where('id', $checkoutId)->where('user_id', $auth->id)->first();
            
            $package = Package::where("id", $checkout->package->id)->first();

            if (!$checkout) {
                return response()->json([
                    "success" => false,
                    "error" => "Checkout record not found"
                ], 404);
            }

            $data = [
                "first_name" => Auth::user()->first_name,
                "last_name" => Auth::user()->last_name,
                "email" => Auth::user()->email,
                "phone" => Auth::user()->phone,
                "package_id" => $package->id,
                "user_id" => $auth->id,
                "invoice" => $checkout->invoice, // Keep existing invoice
                "payment_option" => $request->payment_option
            ];

            // Update the existing checkout record
            $checkout->update($data);
            $checkout->total = $package->price;

            if ($checkout->tax) {
                $checkout->grand_total = $checkout->total + 100 / $checkout->tax;
            }

            $checkout->grand_total = $checkout->package->price;

            

            $checkout->save();

            $gateway = new Shift4Gateway(env('SHIFT4_SECRET'));

            // Create or update customer
            $customerRequest = [
                'email' => $data['email'],
            ];

            $response = Http::withBasicAuth(env('SHIFT4_SECRET'), '')
                ->asForm()
                ->post('https://api.shift4.com/customers', $customerRequest);

            if ($request->payment_option == 'partial') {
                $charge = $request->amount;
                $checkout->paid += $charge;
                $checkout->due = $checkout->grand_total - $checkout->paid;
                $checkout->save();
            } else {
                $charge = $checkout->due;

                $checkout->paid = $checkout->grand_total;
                $checkout->due = 0.00;

                $checkout->save();
            }

            // dd($charge, $checkout->paid, $checkout->due);
            dd($charge);
            $sh_request = [
                'amount' => $charge * 100,
                'currency' => $currency,
                'card' => [
                    'number' => $request->card_number,
                    'expMonth' => $request->mm,
                    'expYear' => $request->yy
                ],
                'customerId' => $response['id'],
                'metadata' =>  [
                    'plan' => $checkout->package->title,
                    'duration' => $checkout->package->duration . 'days'
                ]
            ];

            try {
                $charge = $gateway->createCharge($sh_request);
                $chargeId = $charge->getId();

                if ($charge->getStatus() == "successful") {
                    $checkout->status = "Success";
                    $checkout->payment_status = "Paid";
                    $checkout->save();

                    // Handle package expiration
                    $existed_package = PackageExpiration::where("user_id", $auth->id)->first();

                    if (!$existed_package) {
                        PackageExpiration::create([
                            "package_id" => $checkout->package->id,
                            "user_id" => $auth->id,
                            "duration" => $checkout->package->duration,
                            "is_active" => true,
                            "checkout_id" => $checkout->id
                        ]);
                    } else {
                        $existed_package->package_id = $checkout->package->id;
                        $existed_package->duration = $checkout->package->duration;
                        $existed_package->is_active = true;
                        $existed_package->checkout_id = $checkout->id;
                        $existed_package->save();
                    }

                    // Create or update plan and subscription
                    $planRequest = [
                        'amount' => $checkout->grand_total * 100,
                        'currency' => 'USD',
                        'interval' => 'day',
                        'intervalCount' => $checkout->package->duration,
                        'name' => $checkout->package->duration_title,
                    ];

                    $responsePlan = Http::withBasicAuth(env('SHIFT4_SECRET'), '')
                        ->asForm()
                        ->post('https://api.shift4.com/plans', $planRequest);

                    $subRequest = [
                        'planId' => $responsePlan['id'],
                        'customerId' => $response['id'],
                    ];

                    $responseSub = Http::withBasicAuth(env('SHIFT4_SECRET'), '')
                        ->asForm()
                        ->post('https://api.shift4.com/subscriptions', $subRequest);

                    return redirect(route('checkout.success'));
                }
            } catch (Shift4Exception $se) {
                $checkout->status = "Cancelled";
                $checkout->payment_status = "Unpaid";
                $checkout->save();
                return Inertia::render("Failed", [
                    "error" => $se->getMessage()
                ]);
            }
        } catch (Exception $e) {
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
