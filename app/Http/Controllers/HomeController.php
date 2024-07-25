<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use Inertia\Inertia;
use Exception;


class HomeController extends Controller
{

    public function home() 
    {
        return Inertia::render("Home", [
            "packages" => Package::all()
        ]);
    }


    public function getAllPackages()
    {
        try{
            $packages = Package::all();
            return response()->json([
                "success" => true,
                "data" => $packages
            ]);
        }
        catch(Exception $e) {
            return $e->getMessage();
        }
    }
}
