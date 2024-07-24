<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Package::insert(
        [
            "slug" => "alsdalsd",
            "title" => "Starter",
            "sub_title" => "Best for startup",
            "price" => 28.00,
            "discount" => 0.0,
            "features" => [
                [
                    "golf access" => "No",
                    "Swimming access" => "No",
                    "Free Buffet" => "No"
                ]
            ],

            "duration" => 30


        ],

        [
            "slug" => "sjdhfkjsdhf",
            "title" => "Premium",
            "sub_title" => "Best for Business",
            "price" => 800.00,
            "discount" => 0.0,
            "features" => [
                [
                    "golf access" => "Yes",
                    "Swimming access" => "No",
                    "Free Buffet" => "No"
                ]
            ],

            "duration" => 183
        ]
    
    );
    }
}
