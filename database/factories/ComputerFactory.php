<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Computer>
 */
class ComputerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $count = 1;

        // A01, A02, ..., E05
        $row = chr(64 + ceil($count / 4)); // A-D
        $col = str_pad(($count % 4 ?: 4), 2, '0', STR_PAD_LEFT); // 01-05
        $label = "{$row}{$col}";
        $count++;

        return [
            'label' => $label,
            'status' => fake()->randomElement(['available', 'in_use', 'inactive']),
        ];
    }
}
