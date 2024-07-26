<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                "first_name" => "sakib",
                "last_name" => "ovi",
                "email" => "sakibovi123@gmail.com",
                "password" => Hash::make("admin123123"),
                "image" => "https://w7.pngwing.com/pngs/910/606/png-transparent-head-the-dummy-avatar-man-tie-jacket-user.png",
                "country" => "England",
                "phone" => "+9883234",
                "city" => "London"
            ],
            [
                "first_name" => "Mohona",
                "last_name" => "Chan",
                "email" => "mohona@gmail.com",
                "password" => Hash::make("admin123123"),
                "image" => "https://w7.pngwing.com/pngs/910/606/png-transparent-head-the-dummy-avatar-man-tie-jacket-user.png",
                "country" => "Bangladesh",
                "phone" => "+988233234",
                "city" => "Dhaka"
            ]
        ]);
    }
}
