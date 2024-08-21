<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\PaymentMail;
use App\Models\Checkout;
use App\Models\Package;
use App\Models\PackageExpiration;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Shift4\Shift4Gateway;
use Shift4\Exception\Shift4Exception;
use Illuminate\Support\Facades\Http;

class CheckoutManagementController extends Controller
{
    public function index()
    {
        $orders = Checkout::all();
        return view('admin.orders.index', [
            'orders' => $orders
        ]);
    }

    public function create()
    {
        $loggedInUserId = Auth::id();

        // Retrieve all users
        $users = User::all();

        // Exclude the logged-in user from the collection
        $filteredUsers = $users->reject(function ($user) use ($loggedInUserId) {
            return $user->id == $loggedInUserId;
        });

        $packages = Package::all();

        return view('admin.orders.create', [
            "users" => $filteredUsers,
            "packages" => $packages
        ]);
    }

    public function store( Request $request )
    {
        $user = User::where('id', $request->input('user_id'))->first();

        $checkout = Checkout::create([
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'phone' => $user->phone,
            'user_id' => $user->id,
            'package_id' => $request->input('package_id')
        ]);

        $checkout->grand_total = $checkout->package->price;

        $payment_option = $request->input('payment_method');
        // dd($payment_option);
        if ( $payment_option == 'send_link' ){
            // sending payment link to user
            try {
                $link = route('package.single', [
                    'slug' => $checkout->package->slug
                ]);
                Mail::to('sakibovi123@gmail.com')
                    ->send(new PaymentMail($checkout->package, $checkout->user->first_name, $link));
                    return redirect()->back()->with('message', 'Payment link sent');

            } catch ( Exception $e ) {
                return redirect()->back()->with('message', $e->getMessage());
            }
        }
        else {
            // initiate payment using shift4
            $cardNumber = $request->input('card_number');
            $month = $request->input('month');
            $yy = $request->input('yy');
            $cvv = $request->input('cvv');

            $gateway = new Shift4Gateway(env('SHIFT4_SECRET'));
    
                // creating customer
                $customerRequest = [
                    'email' => $checkout->user->email,
                ];
                
                $response = Http::withBasicAuth(env('SHIFT4_SECRET'), '')
                    ->asForm()
                    ->post('https://api.shift4.com/customers', $customerRequest);

                $sh_request = [
                    'amount' => $checkout->grand_total * 100,
                    'currency' => 'USD',
                    // 'customerId' => $checkout->user_id,
                    'card' => [
                        'number' => $cardNumber,
                        'expMonth' => $month,
                        'expYear' => $yy
                    ],
                    'customerId' => $response['id'],
                    'metadata' =>  [
                        'plan' => $checkout->package->title,
                        'duration' => $checkout->package->duration . 'days'
                    ]
                     
                ];

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
                            $pkg_exp = PackageExpiration::create([
                                "package_id" => $checkout->package->id,
                                "user_id" => $checkout->user->id,
                                "duration" => $checkout->package->duration
                            ]);
                        }
                        else {
                            $existed_package->package_id = $checkout->package->id;
                            $existed_package->duration = $checkout->package->duration;
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
                        $subRequest = [
                            'planId' => $responsePlan['id'],
                            'customerId' => $response['id'],
                        ];

                        $responseSub = Http::withBasicAuth(env('SHIFT4_SECRET'), '')
                            ->asForm()
                            ->post('https://api.shift4.com/subscriptions', $subRequest);

                        return redirect()->back()->with('message', 'Plan bought successfully!');
                    }
                } catch( Shift4Exception $e ) {
                    $checkout->status = "Cancelled";
                    $checkout->payment_status = "Unpaid";
                    $checkout->save();
                    return $e->getMessage();
                }
            
        }

        return back();
    }

    public function edit( $oderId )
    {}

    public function update( Request $request )
    {}

    public function details($orderId)
    {
        $order = Checkout::find($orderId);
        return view('admin.orders.details', [
            'order' => $order 
        ]);
    }
}
