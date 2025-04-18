<?php

namespace Database\Seeders;

use App\Models\Warning;
use Illuminate\Console\View\Components\Warn;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Warning::factory(50)->create();
    }
}
