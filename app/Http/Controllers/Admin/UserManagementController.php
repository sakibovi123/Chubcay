<?php

namespace App\Http\Controllers\Admin;

use App\Exports\EmailExport;
use App\Http\Controllers\Controller;
use App\Mail\SendMailAfterAcceptingRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = DB::table('users')
            ->where('is_admin', 0)
            ->orderByDesc('created_at')
            ->get();
        return view('admin.users.index', [
            'users' => $users
        ]);
    }

    public function activateUser( Request $request )
    {
        

        if ($request->ajax()) {
            $user = User::find($request->input('user_id'));
            // dd($user->email);
            if ($user) {
                $user->status = $request->input('status');

                $user->save();

                // send mail if only accepted
                $message = "Your request has been accepted";

                if($user->status == 'Active'){

                    $link = route('user.takeFee');

                    $user->fee = $request->fee;
                    $user->save();

                    Mail::to($user->email)
                        ->send(new SendMailAfterAcceptingRequest(
                            $message, $request->input('fee'), $link, $user));
                } 

                return response()->json(['message' => 'User updated successfully!']);
            }
    
            return response()->json(['message' => 'User not found.'], 404);
        }
    
        return response()->json(['message' => 'Invalid request.'], 400);

    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store( Request $request )
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'city' => 'required|string',
            // 'balance' => 'numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        
        $user = User::create($data);
        // dd($user);
        return redirect()->back()->with('message', 'User added successfully');
        
    }

    public function edit( $userId )
    {
        $user = User::find($userId);
        return view('admin.users.update', ['user' => $user]);
    }

    public function update( Request $request, $userId )
    {
        $user = User::find($userId);
        // dd($user);
        if( $user )
        {
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            // $user->password = Hash::make($request->input('password'));
            $user->country = $request->input('country');
            $user->city = $request->input('city');
            $user->phone = $request->input('phone');
            $user->balance = $request->input('balance');

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
        return Excel::download(new EmailExport, 'emails.xlsx');
    }
}
