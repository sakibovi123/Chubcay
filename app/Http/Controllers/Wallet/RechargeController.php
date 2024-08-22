<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class RechargeController extends Controller
{
    public function rechargeBalance( Request $request )
    {
        try {
            $user = User::where('id', Auth::user()->id)->first();
            $data = $request->validate([
                'amount' => 'required',
                'cardNumber' => 'required',
                'month' => 'required',
                'year' => 'required',
                'cvv' => 'required'
            ]);
            // dd($data);
            $paymentRequest = [
                "amount" => $data['amount'],
                "currency" => "USD",
                "description" => "Recharge Balance",
                'card' => [
                        'number' => $data['cardNumber'],
                        'expMonth' => $data['month'],
                        'expYear' => $data['year']
                    ],
            ];

            $initiatePayment = Http::withBasicAuth(env('SHIFT4_SECRET'), '')
                ->asForm()
                ->post('https://api.shift4.com/charges', $paymentRequest);
            
            if ( $initiatePayment->status() == 200 )  {
                $user->balance += $data['amount'];

                $user->save();

                // save actions
                Record::create([
                    'user_id' => $user->id,
                    'action' => 'recharge',
                    'amount' => $data['amount']
                ]);
                return back()->with('success', 'Balance updated successfully!');
            }
            else {
                return back()->withErrors(['payment' => 'Payment failed. Please try again.']);
            }
           

        } catch( Exception $e ) {
            return $e->getMessage();
        }
    }
}
