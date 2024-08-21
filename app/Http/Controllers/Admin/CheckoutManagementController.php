<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $checkout = Checkout::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ]);

        $payment_option = $request->input('payment_option');

        if ( $payment_option == 'send_link' ){

        }
        else {
            
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
