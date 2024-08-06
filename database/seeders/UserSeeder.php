<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
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
                "created_at" => Carbon::now(),
                "first_name" => "sakib",
                "last_name" => "ovi",
                "email" => "sakibovi123@gmail.com",
                "password" => Hash::make("admin123123"),
                "image" => "https://w7.pngwing.com/pngs/910/606/png-transparent-head-the-dummy-avatar-man-tie-jacket-user.png",
                "country" => "England",
                "phone" => "+9883234",
                "city" => "London",
                "is_admin" => 1
            ],
            [
                "created_at" => Carbon::now(),
                "first_name" => "Marco",
                "last_name" => "Santullo",
                "email" => "marco@gmail.com",
                "password" => Hash::make("admin123123"),
                "image" => "https://w7.pngwing.com/pngs/910/606/png-transparent-head-the-dummy-avatar-man-tie-jacket-user.png",
                "country" => "Bangladesh",
                "phone" => "+988233234",
                "city" => "Dhaka",
                "is_admin" => 1
            ],
            [
                "created_at" => Carbon::now(),
                "first_name" => "Daimao",
                "last_name" => "Chan",
                "email" => "daimao@gmail.com",
                "password" => Hash::make("admin123123"),
                "image" => "https://w7.pngwing.com/pngs/910/606/png-transparent-head-the-dummy-avatar-man-tie-jacket-user.png",
                "country" => "Bangladesh",
                "phone" => "+988233234",
                "city" => "Dhaka",
                "is_admin" => 0
            ]
        ]);
    }
}
