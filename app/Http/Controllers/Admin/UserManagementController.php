<?php

namespace App\Http\Controllers\Admin;

use App\Exports\EmailExport;
use App\Http\Controllers\Controller;
use App\Mail\PasswordResetMail;
use App\Mail\SendMailAfterAcceptingRequest;
use App\Models\FeeCheckout;
use App\Models\MembershipType;
use App\Models\Record;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Mockery\Exception;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = DB::table('users')
            ->where('is_admin', 0)
            ->orderByDesc('created_at')
            ->get();

        $types = MembershipType::all();

        return view('admin.users.index', [
            'users' => $users,
            'types' => $types
        ]);
    }

    public function activateUser( Request $request )
    {
//        dd($request->all());
        $stat = "";
        if ($request->ajax()) {
//            dd($request->all());
            $user = User::find($request->input('user_id'));
            // dd($user->email);
            if ($user) {
                $user->status = 'Active';

                $user->save();

                // send mail if only accepted
                $message = "Your request has been accepted";

                $type = MembershipType::where('id', $request->fee)
                    ->first();

                $feeObj = FeeCheckout::create([
                    'user_id' => $user->id,
                    'total_charge' => $type->price,
                    'payment_status' => 'due',
                    'due' => $type->price,
                    'payment_status' => $request->payment_status
                ]);

                $link = route('user.takeFee', [
                    'feeId' => $feeObj->id
                ]);

                $user->fee = $type->price;
                $user->save();

                if( $request->payment_option == 'send_link' ) {
                    $stat = "direct";
                    Mail::to($user->email)
                        ->send(new SendMailAfterAcceptingRequest(
                            $message, $type->price, $link, $user, $stat));

                    return response()->json(['message' => 'Payment link sent']);
                }
                else if ( $request->payment_option == 'pay_now' ) {
                    $stat = "manual";
                    if( $request->payment_type == 'full' ) {
                        $feeObj->payment_status = 'paid';
                        $feeObj->save();
                    }
                    else {
                        $feeObj->paid += $request->amount;
                        $feeObj->due -= $request->amount;

                        $feeObj->save();

                    }

                    Mail::to($user->email)
                        ->send(new SendMailAfterAcceptingRequest(
                            $message, $type->price, $link, $user, $stat));
                }

//                else {
//                    return response()->json([
//                        'message' => '400 bad request'
//                    ]);
//                }



                return response()->json(['message' => 'User updated successfully!']);
            }
    
            return response()->json(['message' => 'User not found.'], 404);
        }
    
        return response()->json(['message' => 'Invalid request.'], 400);

    }

    public function create()
    {
        $types = MembershipType::all();
        return view('admin.users.create', [
            'types' => $types
        ]);
    }

    public function store( Request $request )
    {
//        dd($request->membership_type);
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'city' => 'required|string',
//            'membership_type' => 'required|in:Social,Legacy'
             'balance' => 'numeric|regex:/^\d+(\.\d{1,2})?$/',
//            'membership_type' => ''
        ]);


        $data = $request->all();

        $data['password'] = Hash::make($data['password']);

//        dd($request->membership_type);


        $user = User::create($data);

        if( $request->membership_id ) {
            $user->membership_id = $request->membership_id;
            $user->save();
        }

        // dd($user);
        return redirect()->back()->with('message', 'User added successfully');
        
    }

    public function edit( $userId )
    {
        $user = User::find($userId);
        $types = MembershipType::all();

//        dd($user->membership_type->name);

        return view('admin.users.update', [
            'user' => $user,
            'types' => $types
        ]);
    }

    public function update( Request $request, $userId )
    {
        $user = User::find($userId);
        // dd($user);
        if( $user )
        {
//            dd($request->all());
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            // $user->password = Hash::make($request->input('password'));
            $user->country = $request->input('country');
            $user->city = $request->input('city');
            $user->phone = $request->input('phone');
            $user->balance = $request->input('balance');
            $user->status = $request->input('status');
            $user->payment_status = $request->input('payment_status');

            $user->membership_id = $request->membership_id;


//            $user->membership_type = $request->input('membership_type');

            $user->save();

            return back()->with('message', 'User updated');
        }
        else {
            return back()->with('message', 'Something went wrong');
        }
    }

    public function destroy($userId)
    {
        $user = User::find($userId);
        if( $user )
        {
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'user removed',
                'tr' => 'tr_'.$userId
            ]);
        }
        else {
            return response()->json([
                'success' => false,
                'message' => 'something went wrong'
            ]);
        }
    }

    public function exportEmails()
    {
        $dateTime = Carbon::now();
        return Excel::download(new EmailExport, $dateTime.'.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    // sending password reset link
    public function sendPasswordResetLink($userId)
    {
        $user = User::findOrFail($userId);

        $link = route('password.request');

        try{
            Mail::to($user->email)
                ->send(new PasswordResetMail($link));
        }

        catch (\Throwable $e){
            throw $e;
        }

        return back()->with('message', 'Password reset link sent');
    }


    public function createFee(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $users = User::where('is_admin', 0)
            ->get();

        $types = MembershipType::all();

        return view('admin.users.create_fee', [
            'users' => $users,
            'types' => $types
        ]);
    }


    // generate registration fee
    public function payFeeByAdmin( Request $request )
    {
        $charge = 0.00;
//        dd($request->type);

        $validatedData = $request->validate([
            'user_id' => 'required',
            'payment_status' => 'required|in:due,paid',
            'payment_method' => 'required|in:card,cash',
            'type' => 'required'
        ]);


        $user = User::where('id', $validatedData['user_id'])
            ->first();

        $type = MembershipType::where('id', $validatedData['type'])
            ->first();

        $user->fee = $type->price;

        $user->save();

//        dd($user->fee);

        $fee = FeeCheckout::create([
            'user_id' => $validatedData['user_id'],
            'total_charge' => $type->price
        ]);


        if ( $request->payment_method == 'card' )
        {
            if( $request->payment_term == 'full' ) {
                // always have to pay the due
                $charge = $fee->due;
//                $fee->paid += $charge;
                $fee->paid = $user->fee;

                // adding spent money to user's balance
                $user->balance += $fee->paid;
                $user->save();

                $fee->due = 0.00;

                $fee->save();
                // dd($charge);
            }
            else {
                $charge = $request->amount;
                $paid = $request->amount;

                $fee->paid += $request->amount;
                $fee->due = $user->fee - $fee->paid;

                // adding spent money to user's balance
                $user->balance += $fee->paid;
                $user->save();

                $fee->save();
            }

            $feeRequest = [
                "amount" => $charge * 100,
                "currency" => "USD",
                "description" => "Membership Type fee",
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
                $paymentStatus = 'success';
                $user->status = 'Active';
                $updatedUser = User::where('id', $user->id)->first();
                $updatedUser->save();

                // updating checkout fee
                $fee->method = $request->input('payment_method');
                $fee->card_number = $request->card_number;
                $fee->status = 'success';
                $fee->payment_status = 'paid';
                $fee->term = $request->term;

                $fee->save();

                // save record

                Record::create([
                    'user_id' => $fee->user->id,
                    'action' => 'membership fee',
                    'total_amount' => $fee->total_charge,
                    'paid_amount' => $fee->paid,
                    'due_amount' => $fee->due
                ]);

                return redirect()->back()
                    ->with('message', 'Payment successfully!');
            }
            else {
                return redirect()->back()->with('message', 'Payment failed please try again!');
            }
        }
        else # payment_method == 'cash'
        {
            if( $request->payment_term == 'partial' ) {
                $charge = $request->amount;
                $paid = $request->amount;

                $fee->paid += $paid;
                $fee->due = $user->fee - $fee->paid;

                // adding spent money to user's balance
                $user->balance += $fee->paid;
                $user->save();

                $fee->method = $request->input('payment_method');
                $fee->save();
            }
            else {
                $charge = $fee->due;
                $fee->paid = $user->fee;
                $fee->due = 0.00;

                // adding spent money to user's balance
                $user->balance += $fee->paid;
                $user->save();

                $fee->method = $request->input('payment_method');
                $fee->save();
            }

            $fee->payment_status = $request->payment_status;
//            dd($fee->paid, $fee->due);
            $fee->save();

            Record::create([
                'user_id' => $fee->user->id,
                'action' => 'membership fee',
                'total_amount' => $fee->total_charge,
                'paid_amount' => $fee->paid,
                'due_amount' => $fee->due
            ]);

            return redirect()->back()
                ->with('message', 'Payment successfully!');
        }

    }
}
