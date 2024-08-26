<?php

namespace App\Http\Controllers\Fee;

use App\Http\Controllers\Controller;
use App\Models\FeeCheckout;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class FeeCheckoutController extends Controller
{
    public function feeTemplate( $feeId )
    {
        $fee = Auth::user()->fee;
        $feeLink = FeeCheckout::where('id', $feeId)->first();
        // dd($feeLink);
        return view('payfee', [
            'fee' => $fee,
            'feeLink' => $feeLink
        ]);
    }

    public function feeCheckoout( Request $request, $feeId )
    {
        // dd($request->all());
        $charge = 0.00;
        $paid = 0.00;
        $due = 0.00;
        $paymentStatus = '';
        $feeObj = FeeCheckout::where('id', $feeId)
            ->first();

        $request->validate([
            'method' => 'required',
            'term' => 'required|in:full,partial',
            // 'amount' => 'decimal|min:2|max:10'
        ]);

        $user = Auth::user();

        $data = $request->all();
        // dd($data);
        if ( $data['method'] == 'credit_card' ){
            if( $request->term == 'full' ) {
                $charge = $user->fee;
            }
            else {
                $charge = $request->amount;
                $paid = $request->amount;
                $due = $user->fee - $paid;
            }

            $feeRequest = [
                "amount" => $charge,
                "currency" => "USD",
                "description" => "Registration fee",
                'card' => [
                        'number' => $request->card_number,
                        'expMonth' => $request->mm,
                        'expYear' => $request->yy
                ],
            ];
            // dd($feeRequest['amount'] * 100);

            $initiatePayment = Http::withBasicAuth(env('SHIFT4_SECRET'), '')
                ->asForm()
                ->post('https://api.shift4.com/charges', $feeRequest);

            // dd($initiatePayment->json());

            if( $initiatePayment->status() == 200 ) {
                $paymentStatus = 'success';
                $user->status = 'Active';
                $updatedUser = User::where('id', $user->id)->first();
                $updatedUser->save();

                // updating checkout fee
                $feeObj->method = $request->method;
                $feeObj->card_number = $request->card_number;
                $feeObj->status = 'success';
                $feeObj->payment_status = 'paid';
                $feeObj->term = $request->term;
                $feeObj->paid = $paid;
                $feeObj->due = $due;
                $feeObj->save();

                return redirect(route('home.home'))
                    ->with('message', 'Payment successfully!');
            }
            else {
                return redirect()->back()->with('message', 'Payment failed please try again!');
            }
        }
        else {

            // checking term

            if( $request->term == 'partial' )
            {
                $paid = $request->amount;
                $due = $user->fee - $paid;
            }

            $data['user_id'] = $user->id;
            $data['total_charge'] = $user->fee;

            $user->status = 'Pending';
            $updatedUser = User::where('id', $user->id)->first();
            $updatedUser->save();

            $feeObj->user_id = $data['user_id'];
            $feeObj->method = $data['method'];
            $feeObj->check_number = $data['check_number'];
            $feeObj->card_number = $data['card_number'];
            $feeObj->total_charge = $data['total_charge'];

            $feeObj->paid = $paid;
            $feeObj->due = $due;

            if( $paymentStatus == 'success' ) {
                $feeObj->payment_status = 'paid';
                $feeObj->status = $paymentStatus;
            }
            else {
                $feeObj->payment_status = 'due';
                // $feeObj->status = 'failed';
            }

            $feeObj->save();

            return redirect(route('home.home'));
        }
        
    }
}
