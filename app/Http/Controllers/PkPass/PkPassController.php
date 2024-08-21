<?php

namespace App\Http\Controllers\PkPass;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use PKPass\PKPass;

class PkPassController extends Controller
{
    public function generatePass( Request $request )
    {
        $member = User::find($request->id);

        if (!$member) {
            return redirect()->back()->with('error', 'Member not found');
        }

        // Initialize PKPass
        $pass = new PKPass();

        // Certificate and password
        $pass->setCertificatePath('/path/to/certificate.pem');
        $pass->setCertificatePassword('your_certificate_password');

        // Pass data
        $data = [
            'description' => 'Membership Pass',
            'formatVersion' => 1,
            'organizationName' => 'Chubcay',
            'serialNumber' => $member->id,
            'passTypeIdentifier' => 'pass.com.chubcay.membership',
            'teamIdentifier' => 'YOUR_TEAM_ID',
            'backgroundColor' => 'rgb(0,0,0)',
            'foregroundColor' => 'rgb(255,255,255)',
            'barcode' => [
                'message' => $member->id,
                'format' => 'PKBarcodeFormatQR',
                'messageEncoding' => 'iso-8859-1'
            ],
            'labelColor' => 'rgb(255,255,255)',
            'fields' => [
                [
                    'key' => 'memberId',
                    'label' => 'Member ID',
                    'value' => $member->id
                ],
                [
                    'key' => 'expirationDate',
                    'label' => 'Expiration Date',
                    'value' => $member->expiration_date->format('Y-m-d')
                ],
            ]
        ];

        // Load the data into the pass
        $pass->setData($data);

        // Generate and return the pass
        return response($pass->create())->header('Content-Type', 'application/vnd.apple.pkpass');

    }
}
