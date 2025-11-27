<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "Admin",
            "full_name" => "Admin Fullname",
            "jenis_kelamin" => "L",
            "alamat" => "Madiun",
            "no_hp" => "08235672437",
            "email" => "admin@gmail.com",
            "password" => Hash::make("password"),
            "role" => "ADMIN"
        ]);

        User::create([
            "name" => "Satria",
            "full_name" => "Satria Bagus",
            "jenis_kelamin" => "L",
            "alamat" => "Magetan",
            "no_hp" => "082324367",
            "email" => "satria1212@gmail.com",
            "password" => Hash::make("password"),
            "role" => "USER"
        ]);
    }
}
