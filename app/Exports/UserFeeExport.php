<?php

namespace App\Exports;

use App\Models\FeeCheckout;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserFeeExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $user = Auth::user();

        return FeeCheckout::where('user_id', $user->id)
            ->first();
    }
}
