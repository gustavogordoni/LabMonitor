<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Computer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usage>
 */
class UsageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-1 week', 'now');
        $end = (clone $start)->modify('+' . rand(1, 3) . ' hours');

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'computer_id' => Computer::inRandomOrder()->first()->id,
            'start_time' => $start,
            'end_time' => $end,
        ];
    }
}
