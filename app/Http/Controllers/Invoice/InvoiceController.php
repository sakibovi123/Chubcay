<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\Seller;
use LaravelDaily\Invoices\Invoice;

class InvoiceController extends Controller
{
    public function generateInvoice()
    {
        try {
            $user = auth()->user();
            // dd($user);
            $customer = new Buyer([
                'name' => $user->first_name . $user->last_name,
                'phone' => $user->phone,
                'custom_fields' => [
                    'email' => $user->email
                ]
            ]);

            $seller = new Party([
                'name' => 'Chubcay',
                'phone' => '+345345345',
                'custom_fields' => [
                    'vat_id' => '234423432'
                ]
            ]);

            $order = Checkout::where("user_id", $user->id)
                ->latest()
                ->first();
            $item = (new InvoiceItem())->title($order->package->title)
                ->pricePerUnit($order->grand_total)
                ->description(json_encode($order->package->features));
                // dd($item);
            
            $invoice = Invoice::make()
                ->status($order->payment_status)
                ->buyer($customer)
                ->seller($seller)
                ->dateFormat('m/d/y')
                ->date($order->created_at)
                ->serialNumberFormat('{SEQUENCE}/{SERIES}')
                ->currencySymbol('$')
                ->currencyCode('USD')
                ->currencyFormat('{SYMBOL}{VALUE}')
                ->currencyThousandsSeparator('.')
                ->payUntilDays($order->package->duration)
                // ->currencyDecimalPoint(',')
                ->addItem($item);
            
            return $invoice->stream();

        } catch( Exception $e ) {
            return $e->getMessage();
        }
    }


    public function statementGenerator()
    {
        $user = auth()->user();

        $orders = Checkout::where("user_id", $user->id)
            ->get();
        
        $latest_order = Checkout::where("user_id", $user->id)
            ->latest()
            ->first();

        $client = new Party([
            'name'          => 'CHUBCAY',
            
        ]);
        
        $customer = new Party([
            'name'          => $user->first_name . $user->last_name,
            // 'address'       => 'The Green Street 12',
            // 'code'          => '#22663214',
            'phone' => $user->phone,
            'custom_fields' => [
                'Country' => $user->country,
                'City' => $user->city
            ],
        ]);
        

        $items = [];
        foreach( $orders as $order )
        {
            $items[] = InvoiceItem::make($order->package->title)
                ->description(json_encode($order->package->features))
                ->pricePerUnit($order->grand_total)
                ->subTotalPrice($order->total);
        }
        
        // $date = Carbon::now()->toDateString();

        $notes = [
            ''
        ];
        $invoice = Invoice::make('BANK STATEMENT BY SHIFT4')
            ->series('CHB')
            // ability to include translated invoice status
            // in case it was paid
            ->status(__('invoices::invoice.paid'))
            ->sequence(667)
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->seller($client)
            ->buyer($customer)
            ->date(Carbon::now())
            ->dateFormat('m/d/Y')
            ->payUntilDays($latest_order->package->duration)
            ->currencySymbol('$')
            ->currencyCode('USD')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator(',')
            ->currencyDecimalPoint('.')
            ->filename($client->name . ' ' . $customer->name)
            ->addItems($items);


        // $link = $invoice->url();
        // Then send email to party with link

        // And return invoice itself to browser or have a different view
        return $invoice->stream();


        
    }
}
