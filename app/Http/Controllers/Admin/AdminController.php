<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\User;
use Carbon\Carbon;
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

        /// Get the date and time 3 days ago from now
        $threeDaysAgo = Carbon::now()->subDays(3);

        // Get the current date and time (now)
        $now = Carbon::now();

        // Fetch orders created within the last 3 days with pagination (10 items per page)
        $orders = DB::table('checkouts')
            ->whereBetween('created_at', [$threeDaysAgo, $now])
            ->orderByDesc('created_at')
            ->paginate(10);

        // calculating revenue increment by 1 week

        $now = Carbon::now();

        $lastWeekRev = Checkout::whereBetween('created_at', [
            $now->subWeek(1)->startOfWeek(),
            $now->subWeek(1)->endOfWeek()
        ])->sum('grand_total');

        // Get the values from the current week
        $thisWeekValue = Checkout::whereBetween('created_at', [
            $now->startOfWeek(),
            $now->endOfWeek()
        ])->sum('grand_total');

        // Calculate the percentage increase
        if ($lastWeekRev > 0) {
            $percentageIncrease = (($thisWeekValue - $lastWeekRev) / $lastWeekRev) * 100;
        } else {
            $percentageIncrease = 0;
        }

//        dd($percentageIncrease);

        return view('admin.index', [
            'orders' => $orders,
            'totalRevenue' => $totalRevenue,
            'totalCustomers' => $totalCustomers,
            'totalOrders' => $totalOrders,
            'increamentRev' => $percentageIncrease
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

        return redirect()->back()
            ->with('message', "Provided credentials doesn't match");
        
    }


}
