<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use Illuminate\Http\Request;

class CheckoutManagementController extends Controller
{
    public function index()
    {
        $orders = Checkout::all();
        return view('admin.orders.index', [
            'orders' => $orders
        ]);
    }

    public function details($orderId)
    {
        $order = Checkout::find($orderId);
        return view('admin.orders.details', [
            'order' => $order 
        ]);
    }
}
