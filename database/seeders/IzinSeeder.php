<?php

namespace Database\Seeders;

use App\Models\Izin;
use App\Models\User;
use Illuminate\Database\Seeder;

class IzinSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        if ($users->isEmpty()) {
            $users = User::factory()->count(10)->create();
        }

        foreach ($users as $user) {
            Izin::factory()->count(3)->create(['user_id' => $user->id]);
        }
    }
    
}
