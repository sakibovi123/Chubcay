<?php

namespace Database\Seeders;

use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Package::insert(
        [
            [
                "created_at" => Carbon::now(),
                "slug" => Str::uuid(),
                "title" => "Starter",
                "sub_title" => "Best for startup",
                "price" => 28.00,
                "discount" => 0.0,
                "features" => json_encode([
                    "golf access" => "Yes",
                    "Swimming access" => "No",
                    "Free Buffet" => "No"
                ]),
                "duration_title" => "Monthly",
                "duration" => 30
            ],
            [
                "created_at" => Carbon::now(),
                "slug" => Str::uuid(),
                "title" => "Premium",
                "sub_title" => "Best for Business",
                "price" => 800.00,
                "discount" => 0.0,
                "features" => json_encode([
                    "golf access" => "Yes",
                    "Swimming access" => "No",
                    "Free Buffet" => "No"
                ]),
                "duration_title" => "Quaterly",
    
                "duration" => 183
            ],
            [
                "created_at" => Carbon::now(),
                "slug" => Str::uuid(),
                "title" => "Diamond",
                "sub_title" => "Best for Big Business",
                "price" => 2800.00,
                "discount" => 0.0,
                "features" => json_encode([
                    "golf access" => "Yes",
                    "Swimming access" => "Yes",
                    "Free Buffet" => "Yes"
                ]),
                "duration_title" => "Yearly",
                "duration" => 365
            ]
            
        ]
    );
    }
}
