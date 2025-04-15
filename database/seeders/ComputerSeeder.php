<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Computer;

class ComputerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range('A', 'D') as $row) {
            foreach (range(1, 4) as $num) {
                Computer::create([
                    'label' => "{$row}0{$num}",
                    'status' => 'available',
                ]);
            }
        }
    }
}
