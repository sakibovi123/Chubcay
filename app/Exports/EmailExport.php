<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class EmailExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select('first_name', 'last_name', 'email', 'country', 'city', 'phone')->get();
    }

    public function headings(): array
    {
        return ['First Name', 'Last Name', 'Email', 'Country', 'City', 'Phone'];
    }
}
