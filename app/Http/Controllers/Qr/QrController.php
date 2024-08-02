<?php

namespace App\Http\Controllers\Qr;

use App\Http\Controllers\Controller;
use App\Mail\Qrmail;
use App\Models\Checkout;
use App\Services\QrCodeService;
use Barryvdh\DomPDF\Facade\Pdf;
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
           
            $latestOrder = Checkout::with('package:id,title,duration,duration_title')
                ->where('user_id', $user->id)
                ->latest()
                ->first();

            // dd($latestOrder->package->duration_title);
            
            $generateQr = $this->generateQrCode(
                $latestOrder->package->title,
                $latestOrder->package->price,
                $latestOrder->duration
            );

            $pdf = Pdf::loadView('pdf.pdf', [
                'qrImage' => $generateQr,
                'title' => $latestOrder->package->title,
                'price' => $latestOrder->grand_total,
                'duration' => $latestOrder->package->duration,
                'duration_title' => $latestOrder->package->duration_title,
                'name' => $user->first_name . $user->last_name
            ]);
            // dd($generateQr);
            $pdfPath = storage_path('app/public/qrcode-' . time() . '.pdf');
            $pdf->save($pdfPath);

            Mail::to($user->email)
                ->send(new Qrmail($pdfPath));

     
            return redirect()->route('profile.edit');
        }
        catch( Exception $e )
        {
            return response($e->getMessage());
        }
    }
}
