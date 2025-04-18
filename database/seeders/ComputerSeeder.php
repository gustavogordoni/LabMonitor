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
        // foreach (range('A', 'D') as $row) {
        //     foreach (range(1, 5) as $num) {
        //         Computer::create([
        //             'label' => "{$row}0{$num}",
        //             'status' => 'available',
        //         ]);
        //     }
        // }

        $labels = [
            'A01',
            'A02',
            'A03',
            'A04',
            'A05',
            'B01',
            'B02',
            'B03',
            'B04',
            'B05',
            'C01',
            'C02',
            'C03',
            'C04',
            'C05',
            'D01',
            'D02',
            'D03',
            'D04',
            'D05',
        ];

        foreach ($labels as $label){
            Computer::create([
                'label' => $label,
                'status' => 'available',
            ]);
        }
    }
}
