<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
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
}
