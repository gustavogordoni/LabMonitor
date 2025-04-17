<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Computer;
use Carbon\Carbon;

class ComputerDetails extends Component
{
    public Computer $computer;
    public $dailyUsageCount;
    public $activeSessions;

    public function mount($computerId)
    {
        $this->computer = Computer::with(['usages.user'])->findOrFail($computerId);

        $today = Carbon::today();
        $this->dailyUsageCount = $this->computer->usages()
            ->whereDate('start_time', $today)
            ->count();

        $this->activeSessions = $this->computer->usages()
            ->whereNull('end_time')
            ->with('user')
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.computer-details');
    }
}
