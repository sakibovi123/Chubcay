<?php

namespace App\Http\Controllers\Qr;

use App\Http\Controllers\Controller;
use App\Mail\Qrmail;
use App\Models\Checkout;
use App\Services\QrCodeService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use SimpleSoftwareIO\QrCode\Facades\QrCode;


class QrController extends Controller
{
    public function generateQrCode($packageName, $price, $packageDuration, $size = 300)
    {
        $qrData = "Package name: $packageName\nPrice: $$price\nDuration: $packageDuration days";
        $qrCodeImage = 'qrcode-' . time() . '.png';
        $qrPath = storage_path('app/public/'.$qrCodeImage);
        QrCode::format('png')->size($size)->generate($qrData, $qrPath);
        return $qrCodeImage;
    }


    public function sendQrToMail( )
    {
        try
        {
            $user = auth()->user();
           
            $latestOrder = Checkout::with('package:id,title,duration')
                ->where('user_id', $user->id)
                ->latest()
                ->first();
            
            $generateQr = $this->generateQrCode(
                $latestOrder->package->title,
                $latestOrder->package->price,
                $latestOrder->duration
            );
            // dd($generateQr);
            Mail::to($user->email)
                ->send(new Qrmail($generateQr));

     
            return response('Success');
        }
        catch( Exception $e )
        {
            return response($e->getMessage());
        }
    }
}
