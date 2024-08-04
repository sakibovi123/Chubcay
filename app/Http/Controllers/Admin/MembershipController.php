<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Rules\DurationRule;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    // index
    public function memberShipIndex()
    {
        $plans = Package::all();
        return view('admin.membership.index', [
            'plans' => $plans
        ]);
    }

    // create
    public function createMembership()
    {
        return view('admin.membership.create');
    }

    // store
    public function storeMembership( Request $request )
    {
        $request->validate([
            'title' => 'required|string',
            'sub_title' => 'required|string',
            'price' => 'required',
            'discount' => 'nullable',
            'duration' => 'nullable|integer',
            'duration_title' => 'nullable',
            'status' => 'nullable|in:Active,Deactive',
            'features' => 'array',
            'features.*.key' => 'nullable|string',
            'features.*.value' => 'nullable|string',
        ]);
        
        $data = $request->all();

        // checking for discount
        if( $request->has('discount') )
        {
            // dd($data['price']);
            $discount_price = $data['price'] * $data['discount'] / 100;
            $data['price'] -= $discount_price;
        }
        // dd($data);
        $package = Package::create($data);

        if ($request->has('features')) {
            $features = $request->input('features');
            $processedFeatures = [];
            
            foreach ($features as $feature) {
                
                if (isset($feature['key']) && isset($feature['value'])) {
                    // dd('asdasd');
                    $processedFeatures[$feature['key']] = $feature['value'];
                }
            }

            // Convert to JSON if needed
            // $featuresJson = json_encode($processedFeatures);
    
            // Save to the model
            
            $package->features = $processedFeatures;
            $package->save();
        }

        return back()->with('message', 'Plan added successfully!');
    }

    // edit
    public function editMembership( $slug )
    {
        $package = Package::where('slug', $slug)->first();
        return view('admin.membership.update', [
            'package' => $package
        ]);
    }

    // update
    public function updateMembership( Request $request, $slug )
    {
        $package = Package::where('slug', $slug)->first();

        if ( $package )
        {
            $package->title = $request->input('title');
            $package->sub_title = $request->input('sub_title');
            $package->price = $request->input('price');

            // if discount is present
            if( $request->input('discount') ) 
            {
                $discount = $request->input('discount');
                $package->price = $request->input('price') * $discount / 100;
            }
            
            $package->features = $request->input('features'); // only accepts array
            $duration_title = $request->input('duration_title');
 
            if( $duration_title == 'monthly' ) {
                $package->duration = 30;
            }
            else if ( $duration_title == 'quaterly' )
            {
                $package->duration = 183;
            }

            else if ( $duration_title == 'yearly' )
            {
                $package->duration = 365;
            }

            $package->status = $request->input('status');

            $package->save();
            return redirect()->back();

        }
        else {
            return back()->with('error', 'Package not found!');
        }
    }
}
