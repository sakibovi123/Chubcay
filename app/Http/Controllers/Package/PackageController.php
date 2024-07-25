<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PackageController extends Controller
{
    public function index() {
        try{
            $packages = Package::all();
            // dd($packages);
            return response()->json([
                "success" => true,
                "data" => $packages
            ], 200);
        }

        catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public function getSinglePackageDetails($slug) {
        try{
            $package = Package::where("slug", $slug)->first();

            return Inertia::render("", [
                "package" => $package
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
            throw $e->getMessage();
        }
    }


    public function destroy($slug) {
        try {
            $package = Package::where("slug", $slug)->first();
            $package->delet();
            return redirect(route(''));
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }
}
