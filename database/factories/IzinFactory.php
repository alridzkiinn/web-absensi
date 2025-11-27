<?php

namespace Database\Factories;

use App\Models\Izin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class IzinFactory extends Factory
{
    protected $model = Izin::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'tanggal' => $this->faker->date(),
            'keterangan' => $this->faker->randomElement(['sakit', 'izin']),
            'photo_path' => $this->faker->imageUrl(),
            'catatan' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['sudah', 'belum', 'tolak']),
        ];        
    }
}
