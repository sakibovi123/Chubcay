<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function editSettings()
    {
        $settings = Settings::first();
        return view('admin.settings.settings', [
            'settings' => $settings
        ]);
    }


    public function updateSettings( Request $request )
    {
        $settings = Settings::first();

        if ( $settings ) {
            $data = $request->validate([
                'registration_fee' => 'required|decimal:1,100'
            ]);

            $settings->registration_fee = $data['registration_fee'];

            $settings->save();

            return redirect()
                    ->back()
                    ->with('message', 'Settings updated');
        }
        else {
            return redirect()
                    ->back()
                    ->with('message', 'Settings update failed!');
        }
        
        // return null;
    }
}
