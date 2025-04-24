<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'enrollment' => 'VP9999999',
            'email' => 'admin@email.com',
            'password' => Hash::make('password'),
            'course' => 'Sistemas de Informação',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Test',
            'enrollment' => 'VP8888888',
            'email' => 'test@email.com',
            'password' => Hash::make('password'),
            'course' => 'Informática',
        ]);

        User::factory(50)->create();
    }
}
