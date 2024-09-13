<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\PaymentMail;
use App\Models\Checkout;
use App\Models\Package;
use App\Models\PackageExpiration;
use App\Models\Record;
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
        $orders = Checkout::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.orders.index', [
            'orders' => $orders
        ]);
    }

    // public function c

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


        $validated = $request->validate([
            'custom_fields' => 'array',
            'custom_fields.*.key' => 'nullable|string|max:255',
            'custom_fields.*.value' => 'nullable|string|max:255',
        ]);

        // dd($validated);
//        dd($request->payment_status, $request->payment_term);

        $checkout = Checkout::create([
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'phone' => $user->phone,
            'user_id' => $user->id,
            'package_id' => $request->input('package_id'),
            'payment_method' => $request->input('payment_method'),
            'payment_status' => $request->payment_status,
            'payment_option' => $request->payment_term,
        ]);
        
        // saving extra fields
        
        $jsonCustomFields = json_encode($validated['custom_fields']);

        $checkout->custom_fields = $jsonCustomFields;
        $checkout->save();

        $checkout->grand_total = $checkout->package->price;

        $payment_option = $request->input('payment_option');
        // dd($payment_option);
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

            if( $request->payment_method == 'cash' )
            {
                $checkout->payment_method = 'cash';
                // check for full or partial
                if( $request->payment_term == 'partial' )
                {
                    $checkout->paid += $request->amount;

                    // adding spent money to user's balance
                    $user->balance += $checkout->paid;
                    $user->save();

                    $checkout->due = $checkout->grand_total - $checkout->paid;
                }
                else
                {
                    $checkout->paid = $checkout->grand_total;

                    // adding spent money to user's balance
                    $user->balance += $checkout->paid;
                    $user->save();

                    $checkout->due = 0.00;
                }

                $checkout->save();

                // saving records
                Record::create([
                    'user_id' => $checkout->user->id,
                    'action' => 'plan checkout fee',
                    'total_amount' => $checkout->grand_total,
                    'paid_amount' => $checkout->paid,
                    'due_amount' => $checkout->due
                ]);

                return back()->with('message', 'Plan bought successfully');
            }

//            dd($request->cheque);

            $charge = 0.00;

            if( $request->payment_term == 'partial' ) {
                $charge = $request->amount;

                $checkout->paid += $request->amount;
                $checkout->due = $checkout->grand_total - $checkout->paid;

            } else {
                $checkout->paid = $checkout->grand_total;
                $checkout->due = 0.00;
            }

            // saving payment method
            $checkout->cheque = $request->cheque;
            $checkout->payment_method = $request->payment_method;
            $checkout->save();

//            dd($checkout);

            // saving records
            Record::create([
                'user_id' => $checkout->user->id,
                'action' => 'plan checkout fee',
                'total_amount' => $checkout->grand_total,
                'paid_amount' => $checkout->paid,
                'due_amount' => $checkout->due
            ]);


            // initiate payment using cheque
//            $cardNumber = $request->input('card_number');
//            $month = $request->input('month');
//            $yy = $request->input('yy');
//            $cvv = $request->input('cvv');
//
//            $gateway = new Shift4Gateway(env('SHIFT4_SECRET'));
//
//                // creating customer
//                $customerRequest = [
//                    'email' => $checkout->user->email,
//                ];
//
//                $response = Http::withBasicAuth(env('SHIFT4_SECRET'), '')
//                    ->asForm()
//                    ->post('https://api.shift4.com/customers', $customerRequest);
//
            // checking term






//                try{
//                    $charge = $gateway->createCharge($sh_request);
//
//                    $chargeId = $charge->getId();
//
//                    if( $charge->getStatus() == "successful" ) {
//                        $checkout->status = "Success";
//                        $checkout->payment_status = "Paid";
//                        if( $request->payment_temr == 'full' )
//                        {
//                            $checkout->paid = $checkout->grand_total;
//                            $checkout->due = 0.00;
//                        }
//
//                        $checkout->save();
//
//                        // saving package expiration model
//                        // need to check if one already exist then replace the package
//
//                        $existed_package = PackageExpiration::where("user_id", $request->user()->id)
//                            ->first();
//
//                        if( !$existed_package )
//                        {
//                            $pkg_exp = PackageExpiration::create([
//                                "checkout_id" => $checkout->id,
//                                "package_id" => $checkout->package->id,
//                                "user_id" => $checkout->user->id,
//                                "duration" => $checkout->package->duration
//                            ]);
//                        }
//                        else {
//                            $existed_package->package_id = $checkout->package->id;
//                            $existed_package->duration = $checkout->package->duration;
//                            $existed_package->save();
//                        }
//
//                        // creating plans and subs
////                        $planRequest = [
////                            'amount' => $checkout->grand_total * 100,
////                            'currency' => 'USD',
////                            'interval' => 'day',
////                            'intervalCount' => $checkout->package->duration,
////                            'name' => $checkout->package->duration_title,
////                        ];
//
////                        $responsePlan = Http::withBasicAuth(env('SHIFT4_SECRET'), '')
////                            ->asForm()
////                            ->post('https://api.shift4.com/plans', $planRequest);
////
////                        // processing subscription
////                        $subRequest = [
////                            'planId' => $responsePlan['id'],
////                            'customerId' => $response['id'],
////                        ];
////
////                        $responseSub = Http::withBasicAuth(env('SHIFT4_SECRET'), '')
////                            ->asForm()
////                            ->post('https://api.shift4.com/subscriptions', $subRequest);
////
////                        // saving records
//
//                        Record::create([
//                            'user_id' => $checkout->user->id,
//                            'action' => 'plan checkout fee',
//                            'total_amount' => $checkout->grand_total,
//                            'paid_amount' => $checkout->paid,
//                            'due_amount' => $checkout->due
//                        ]);
//
//                        return redirect()->back()->with('message', 'Plan bought successfully!');
//                    }
//                } catch( Shift4Exception $e ) {
//                    $checkout->status = "Cancelled";
//                    $checkout->payment_status = "Unpaid";
//                    $checkout->save();
//                    return $e->getMessage();
//                }
            
        }

        // PackageExpiration::create();

        return back();
    }

    public function edit( $orderId )
    {
        $order = Checkout::find($orderId);
       
        return view('admin.orders.edit', [
            'order' => $order
        ]);
    }

    public function update( Request $request, $orderId )
    {
        $order = Checkout::findOrFail($orderId);

        // select existing user or create one
        // $user = User::where('id', $request->input('user_id'))->first();

        $validated = $request->validate([
            'custom_fields' => 'required|array',
            'custom_fields.*.key' => 'required|string|max:255',
            'custom_fields.*.value' => 'required|string|max:255',
        ]);

        $jsonCustomFields = json_encode($validated['custom_fields']);

        $order->custom_fields = $jsonCustomFields;
        $order->save();

        return back()->with('message', 'Updated Successfully');

    }

    public function details($orderId)
    {
        $order = Checkout::find($orderId);

        return view('admin.orders.details', [
            'order' => $order 
        ]);
    }

    public function destroy( $orderId )
    {
        $order = Checkout::where('id', $orderId)
            ->first();

        $order->delete();

        return back()->with('message', 'Order removed');
        
    }
}
