<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Computer;
use App\Models\Usage;

class ComputerSelection extends Component
{
    public $computers;
    public $activeUsage;

    public function mount()
    {
        $this->computers = Computer::all();
        $this->activeUsage = Usage::where('user_id', auth()->user()->id)
            ->whereNull('end_time')
            ->first();
    }

    public function select($id)
    {
        if ($this->activeUsage) {
            session()->flash('error', 'You already have an active session.');
            return;
        }

        $computer = Computer::findOrFail($id);

        if ($computer->status !== 'available') {
            session()->flash('error', 'This computer is not available.');
            return;
        }

        Usage::create([
            'user_id' => auth()->user()->id,
            'computer_id' => $computer->id,
            'start_time' => now(),
        ]);

        $computer->update(['status' => 'in_use']);
        $this->mount(); // Refresh data
    }

    public function cancel()
    {
        if (!$this->activeUsage) return;

        $this->activeUsage->update(['end_time' => now()]);
        $this->activeUsage->computer->update(['status' => 'available']);
        $this->mount(); // Refresh data
    }
}
