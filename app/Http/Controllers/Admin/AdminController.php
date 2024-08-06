<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function adminIndex()
    {
        $totalRevenue = Checkout::sum('grand_total');
        $totalCustomers = count(User::all());
        $totalOrders = count(Checkout::all());

        $orders = DB::table('checkouts')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.index', [
            'orders' => $orders,
            'totalRevenue' => $totalRevenue,
            'totalCustomers' => $totalCustomers,
            'totalOrders' => $totalOrders
        ]);
    }

    // admin login
    public function adminLoginView()
    {
        return view('admin.auth.login');
    }

    // admin login request
    public function adminLogin( Request $request )
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if( Auth::attempt($credentials) )
        {
            if( Auth::user() ){
                $user = Auth::user();

                if( $user->is_admin == 1 ) {
                    return redirect()->route('admin.index');
                }
                else {
                    return redirect()->route('admin.auth.login');
                }
            }
            
        }

        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
        
    }


}
