<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        // dd(auth()->user()->package->title);
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'user' => auth()->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // dd($request->user()->email);
        $request->user()->fill($request->validated());
        // if( $ )
        // if( $request->get('') )
        // {}
        if( $request->get('first_name')
             | $request->get('last_name')
             | $request->get('last_name')
             | $request->get('country')
             | $request->get('phone')
             | $request->get('city')
        ) {
            $request->user()->first_name = $request->get('first_name');

            $request->user()->last_name = $request->get('last_name');

            $request->user()->country = $request->get('country');

            $request->user()->phone = $request->get('phone');

            $request->user()->city = $request->get('city');
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

        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }

        $request->user()->save();

        return Redirect::route('profile.edit');
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
