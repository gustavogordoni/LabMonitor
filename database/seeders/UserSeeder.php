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
        if (env('ADMIN_NAME') && env('ADMIN_ENROLLMENT') && env('ADMIN_EMAIL') && env('ADMIN_PASSWORD')) {
            User::create([
                'name' => env('ADMIN_NAME'),
                'enrollment' => env('ADMIN_ENROLLMENT'),
                'email' => env('ADMIN_EMAIL'),
                'password' => Hash::make(env('ADMIN_PASSWORD')),
                'course' => 'Sistemas de Informação',
                'role' => 'admin',
            ]);
        }

        if (env('STUDENT_NAME') && env('STUDENT_ENROLLMENT') && env('STUDENT_EMAIL') && env('STUDENT_PASSWORD')) {
            User::create([
                'name' => env('STUDENT_NAME'),
                'enrollment' => env('STUDENT_ENROLLMENT'),
                'email' => env('STUDENT_EMAIL'),
                'password' => Hash::make(env('STUDENT_PASSWORD')),
                'course' => 'Informática',
            ]);
        }

        // User::factory(50)->create();
    }
}
