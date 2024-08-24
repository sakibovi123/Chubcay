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
    public function feeTemplate()
    {
        $fee = Auth::user()->fee;

        return view('payfee', [
            'fee' => $fee
        ]);
    }

    public function feeCheckoout( Request $request )
    {
        $request->validate([
            'method' => 'required',
            // 'user_id' => 'required'
        ]);

        $user = Auth::user();

        $data = $request->all();
        // dd($data);
        if ( $data['method'] == 'credit_card' ){
            // dd('card');
            
            $feeRequest = [
                "amount" => $user->fee * 100,
                "currency" => "USD",
                "description" => "Registration fee",
                'card' => [
                        'number' => $request->card_number,
                        'expMonth' => $request->mm,
                        'expYear' => $request->yy
                ],
            ];

            $initiatePayment = Http::withBasicAuth(env('SHIFT4_SECRET'), '')
                ->asForm()
                ->post('https://api.shift4.com/charges', $feeRequest);

            if( $initiatePayment->status() == 200 ) {
                $user->status = 'Active';
                $updatedUser = User::where('id', $user->id)->first();
                $updatedUser->save();
                return redirect(route('home.home'))
                    ->with('message', 'Payment successfully!');
            }
            else {
                return redirect()->back()->with('message', 'Payment failed please try again!');
            }
        }
        
        $data['user_id'] = $user->id;
        $data['total_charge'] = $user->fee;

        $user->status = 'Pending';
        $updatedUser = User::where('id', $user->id)->first();
        $updatedUser->save();

        FeeCheckout::create($data);

        return redirect(route('home.home'));
    }
}
