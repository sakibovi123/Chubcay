<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembershipTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('membership_types')->insert([
            [
                'created_at' => Carbon::now(),
                'name' => 'Social',
                'price' => 50000.00
            ],
            [
                'created_at' => Carbon::now(),
                'name' => 'Legacy',
                'price' => 80000.00
            ],
        ]);
    }
}
