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
    
            // Save to the model
            
            $package->features = $processedFeatures;

            // if active package len is getter than 3 then
            // saved package will be deactivated automatically
            $active_package = Package::where('status', 'Active')
                ->get();
            
            if ( count($active_package) > 3 )
            {
                $package->status = 'Deactive';
            }

            $package->save();
        }

        return redirect()->route('membership.index')->with('message', 'Plan added successfully!');
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
        $request->validate([
            'features' => 'array',
            'features.*.key' => 'nullable|string',
            'features.*.value' => 'nullable|string',
        ]);

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
            
            if(  $request->has('features') ) {
                $features = $request->input('features'); 
                $processedFeatures = [];
            
                foreach ($features as $feature) {
                    if (isset($feature['key']) && isset($feature['value'])) {
                        // dd('asdasd');
                        $processedFeatures[$feature['key']] = $feature['value'];
                    }
                }

                $package->features = $processedFeatures;
            }
            
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
            return back()->with('error', 'Updated successfully');

        }
        else {
            return back()->with('error', 'Package not found!');
        }
    }

    public function destroyPackage( $package_id )
    {
        $packageId = Package::where('id', $package_id)
            ->first();

        if( $packageId ){
            $packageId->delete();
            return back()->with('success', 'Package removed');
        }
        else {
            return back()->with('error', 'Failed to find package');
        }

        
    }
}
