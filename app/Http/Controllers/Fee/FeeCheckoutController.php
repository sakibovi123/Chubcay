<?php

namespace App\Http\Controllers\Fee;

use App\Http\Controllers\Controller;
use App\Models\FeeCheckout;
use App\Models\Record;
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
        $charge = 0.00;
    
        $paymentStatus = '';
        $paid = 0.00;

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
                // always have to pay the due
                $charge = $feeObj->due;
                $feeObj->paid += $charge;
                $feeObj->due = 0.00;

                $feeObj->save();
                // dd($charge);
            }
            else {
                $charge = $request->amount;

                $paid = $request->amount;
//                $due = $user->fee - $paid;

                $feeObj->paid += $paid;
                $feeObj->due -= $paid;
//                dd($feeObj->due, $paid, $user->fee);
                $feeObj->save();
            }

            // dd($charge);

            $feeRequest = [
                "amount" => $charge * 100,
                "currency" => "USD",
                "description" => "Registration fee",
                'card' => [
                        'number' => $request->card_number,
                        'expMonth' => $request->mm,
                        'expYear' => $request->yy
                ],
            ];
            // dd($feeRequest['amount']);

            // dd($feeObj->due);

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
                $feeObj->method = $request->input('method');
                $feeObj->card_number = $request->card_number;
                $feeObj->status = 'success';
                $feeObj->payment_status = 'paid';
                $feeObj->term = $request->term;

                $feeObj->save();

                // save record

                Record::create([
                    'user_id' => $feeObj->user->id,
                    'action' => 'registration fee',
                    'total_amount' => $feeObj->total_charge,
                    'paid_amount' => $feeObj->paid,
                    'due_amount' => $feeObj->due
                ]);

                return redirect()->route('home.home')
                    ->with('message', 'Payment successfully!');
            }
            else {
                return redirect()->back()->with('message', 'Payment failed please try again!');
            }
        }
//        else {
//            $data['user_id'] = $user->id;
//            $data['total_charge'] = $user->fee;
//
//            $user->status = 'Pending';
//            $updatedUser = User::where('id', $user->id)->first();
//            $updatedUser->save();
//
//            if( $request->term == 'partial' )
//            {
//                $charge = $request->amount;
//                $feeObj->paid += $request->amount;
//
//                $feeObj->due = $user->fee - $feeObj->paid;
//                // dd($user->fee);
//                $feeObj->save();
//            }
//            else {
//                $charge = $feeObj->due;
//                $feeObj->paid += $feeObj->due;
//                $feeObj->due = 0.00;
//
//                $feeObj->save();
//            }
//
//
//            $feeObj->user_id = $data['user_id'];
//            $feeObj->method = $data['method'];
//            $feeObj->check_number = $data['check_number'];
//
//            $feeObj->total_charge = $data['total_charge'];
//
//
//            if( $paymentStatus == 'success' ) {
//                $feeObj->payment_status = 'paid';
//                $feeObj->status = $paymentStatus;
//            }
//            else {
//                $feeObj->payment_status = 'due';
//                // $feeObj->status = 'failed';
//            }
//
//            $feeObj->save();
//
//            //saving records
//
//            Record::create([
//                'user_id' => $feeObj->user->id,
//                'fee_checkout_id' => $feeObj->id,
//                'action' => 'fee',
//                'amount' => $charge
//            ]);
//
//            return redirect(route('home.home'));
//        }
        
    }
}
