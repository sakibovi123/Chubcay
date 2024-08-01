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

class QrController extends Controller
{

    protected $qrService;

    public function __construct(QrCodeService $qrService)
    {
        $this->qrService = $qrService;
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
            // dd($latestOrder);
            // if( !$latestOrder || $latestOrder->package ) 
            // {
                
            //     return redirect()->back()->with('Error', 'Order not found!');
            // }
            
            $generateQr = $this->qrService->generateQrCode(
                $latestOrder->package->title, $latestOrder->duration
            );
            // dd($generateQr);
           
            // Mail::to($user->email)
            //     ->send(new Qrmail($generateQr));
            $data = ['name' => 'Cyan'];
            try {
                Mail::send('mail.qr', $data, function($message) {
                    $message->to('sakibovi123@gmail.com', 'CMPUNK')->subject('Kire!');
                    $message->from('noreply@members.chubcay-stage.online', 'John');
                });
                Log::info('Mail sent successfully.');
            } catch (Exception $e) {
                Log::error('Mail could not be sent: ' . $e->getMessage());
            }
            
            // return response('Success');
        }
        catch( Exception $e )
        {
            return response($e->getMessage());
        }
    }
}
