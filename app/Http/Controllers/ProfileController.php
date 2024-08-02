<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\PackageExpiration;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        $filePath = '';
        $existing_package = PackageExpiration::where("user_id", $request->user()->id)
            ->first();
        $package_token = null;

        if( $existing_package ) 
        {
            $package_name = $existing_package->package->title;
            $package_user = $existing_package->user->email;

            // $package_token = QrCode::format('png')->generate($existing_package->token);
        }

        // generate QR
        $qr = $this->generateQrCode(
            $existing_package->package->title,
            $existing_package->package->price,
            $existing_package->price
        );
        
        $profile_image = Storage::url(auth()->user()->image);
        // echo "<img src='storage_path('app/public/' . $qr)'>";

        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'user' => auth()->user(),
            'profile_image' => $profile_image,
            'existing_package' => $existing_package,
            'package_token' => $package_token,
            'qr' => storage_path('app/public/'.$qr)
            
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // dd($request->user()->email);
        $request->user()->fill($request->validated());

        if( $request->get('first_name')
             | $request->get('last_name')
             | $request->get('last_name')
             | $request->get('country')
             | $request->get('phone')
             | $request->get('city')
             | $request->get('image')
        ) {
            $request->user()->first_name = $request->get('first_name');

            $request->user()->last_name = $request->get('last_name');

            $request->user()->country = $request->get('country');

            $request->user()->phone = $request->get('phone');

            $request->user()->city = $request->get('city');
            
            // $image = $request->user()->image = $request->get('image');
            $image = $request->get('image');
            // dd($image);
            // updating image
            if (!$request->user()->image && !Storage::disk('public')->exists($image)) {
                $image_parts = explode(";base64,", $image);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = Str::random(10) . '.' . ($image_type === 'jpeg' ? 'jpg' : 'png');
                $filePath = 'selfies/' . $fileName;
        
                // Save the image to the storage
                Storage::disk('public')->put($filePath, $image_base64);
        
                // Update user's image path
                $request->user()->image = $filePath;
                $request->user()->save();
                // dd("IF");
            } else {
                // Use the existing image path
                // dd("ELSE");
                $imagePath = $request->user()->image;
                $request->user()->image = $imagePath;
                $request->user()->save();
            }

        if( $request->get('current_password') && $request->get('new_password') ) {
            if( Hash::check( $request->get('current_password'), $request->user()->password ) )
            {
                $request->user()->password  = bcrypt($request->get('new_password'));
                $request->user()->save();
            }
            else
            {
                return back()->with([
                    "message" => "Password doesn't match!"
                ]);
            }
        }

        
        $request->user()->save();

        return Redirect::route('profile.edit');
    }
}

    public function generateQrCode($packageName, $price, $packageDuration, $size = 300)
    {
        $qrData = "Package name: $packageName\nPrice: $$price\nDuration: $packageDuration days";
        $qrCodeImage = 'qrcode-' . time() . '.png';
        QrCode::format('png')->size(256)->generate($qrData, storage_path('app/public/' . $qrCodeImage));
        return $qrCodeImage;
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
