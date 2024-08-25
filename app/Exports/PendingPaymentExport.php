<?php

namespace App\Exports;

use App\Models\FeeCheckout;
use Maatwebsite\Excel\Concerns\FromCollection;

class PendingPaymentExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return FeeCheckout::where('payment_status', 'due')
            ->get();
    }
}
