<?php

namespace App\Services;

use Shift4\Shift4Gateway;
// use Shift4\Requests\CheckoutRequest;
// use Shift4\Requests\CheckoutRequestCharge;
use Shift4\Request\CheckoutRequestCharge;
use Shift4\Request\CheckoutRequest;

class Shift4Service
{
    protected $shift4;

    public function __construct()
    {
        $this->shift4 = new Shift4Gateway(env('SHIFT4_SECRET'));
    }

    public function createSignedCheckoutRequest($amount, $currency)
    {
        $checkoutCharge = new CheckoutRequestCharge();
        $checkoutCharge->amount($amount)->currency($currency);

        $checkoutRequest = new CheckoutRequest();
        $checkoutRequest->charge($checkoutCharge);

        return $this->shift4->signCheckoutRequest($checkoutRequest);
    }
}
