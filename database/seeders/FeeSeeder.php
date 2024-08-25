<?php

namespace Database\Seeders;

use App\Models\FeeCheckout;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FeeCheckout::insert([
            [
                'created_at' => Carbon::now(),
                'user_id' => 1,
                'method' => 'check',
                'total_charge' => 500.00,
                'status' => 'success',
                'payment_status' => 'paid'
            ],
            [
                'created_at' => Carbon::now(),
                'user_id' => 1,
                'method' => 'check',
                'total_charge' => 500.00,
                'status' => 'failed',
                'payment_status' => 'due'
            ],
            [
                'created_at' => Carbon::now(),
                'user_id' => 1,
                'method' => 'check',
                'total_charge' => 500.00,
                'status' => 'success',
                'payment_status' => 'paid'
            ],
            [
                'created_at' => Carbon::now(),
                'user_id' => 1,
                'method' => 'check',
                'total_charge' => 500.00,
                'status' => 'failed',
                'payment_status' => 'due'
            ],
            [
                'created_at' => Carbon::now(),
                'user_id' => 1,
                'method' => 'check',
                'total_charge' => 500.00,
                'status' => 'success',
                'payment_status' => 'paid'
            ],
            [
                'created_at' => Carbon::now(),
                'user_id' => 1,
                'method' => 'check',
                'total_charge' => 500.00,
                'status' => 'failed',
                'payment_status' => 'due'
            ]
        ]);
    }
}
