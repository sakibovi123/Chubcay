<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Shift4\Shift4Gateway;
use Shift4\Request\CheckoutRequest;
use Shift4\Request\CheckoutRequestCharge;


class PackageController extends Controller
{
    public function index() {
        try{
            $packages = Package::all();

            return Inertia::render("Pages/Home", [
                "packages" => $packages
            ]);
        }

        catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public function getSinglePackageDetails($slug) {
        try{
            $auth = auth()->user();
            $package_details = Package::where("slug", $slug)->first();

            $shift4 = new Shift4Gateway(env('SHIFT4_SECRET'));
                
            $checkoutCharge = new CheckoutRequestCharge();
            $checkoutCharge->amount($package_details->price * 100)->currency('USD');
            // dd($checkoutCharge);
            $checkoutRequest = new CheckoutRequest();
            $checkoutRequest->charge($checkoutCharge);

            $shift4Payment =  $shift4->signCheckoutRequest($checkoutRequest);



            return Inertia::render("PackageDetails", [
                "package_details" => $package_details,
                "shift4Payment" => $shift4Payment,
                "SHIFT4_PK" => env('SHIFT4_PK'),
                'auth' => $auth
            ]);

        } catch( Exception $e) {
            return $e->getMessage();
        }
        
    }

    public function create() {
        return Inertia::render("");
    }


    public function store(Request $request) {

        $validated_data = $request->validate([
            "title" => "required|string|unique",
            "sub_title" => "required|string",
            "price" => "required|decimal",
            "features" => "required|json"
        ]);
        
        $package = Package::create($request->all());

        return redirect(route(''));

    }


    public function edit($slug) {
        try{
            $package = Package::where("slug", $slug)->first();
            return Inertia::render("", []);
        } catch( Exception $e ) {
            return $e->getMessage();
        }
    }


    public function update(Request $request, $slug) {
        try {
            $package = Package::where("slug", $slug)->first();

            if ( $package ) {
                $package->title = $request->title;
                $package->sub_title = $request->sub_title;
                $package->price = $request->price;
                $package->features = $request->features;
                $package->discount = $request->discount;

                $package->save();

                return redirect(route(''));
            }
            else {
                return response()->json([
                    "success" => false,
                    "message" => "Package not found!"
                ], 404);
            }
        } catch ( Exception $e ) {
            return $e->getMessage();
        }
    }


    public function destroy($slug) {
        try {
            $package = Package::where("slug", $slug)->first();
            $package->delet();
            return redirect(route(''));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
