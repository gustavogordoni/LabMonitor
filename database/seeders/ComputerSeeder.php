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
        $path = database_path('data/computers.json');

        if (!file_exists($path)) {
            $this->command->warn('Arquivo JSON de computadores (database/data/computers.json) não encontrado. Nenhum computador foi cadastrado.');
            return;
        }

        $json = file_get_contents($path);
        $computersByRoom = json_decode($json, true);

        if (empty($computersByRoom)) {
            $this->command->warn('Arquivo JSON de computadores está vazio. Nenhum computador foi cadastrado.');
            return;
        }

        foreach ($computersByRoom as $computers) {
            foreach ($computers as $computer) {
                Computer::create([
                    'label' => $computer['label'],
                    'code' => $computer['code'],
                    'status' => 'available',
                ]);
            }
        }
    }
}
