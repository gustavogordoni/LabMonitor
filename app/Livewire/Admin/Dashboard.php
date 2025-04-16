<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Usage;
use App\Models\Computer;
use App\Models\Warning;

class Dashboard extends Component
{
    public $totalUsers;
    public $activeUsages;
    public $availableComputers;
    public $totalWarnings;
    public $activeSessions;
    public $completedToday;

    public function mount()
    {
        $this->totalUsers = User::count();
        $this->activeUsages = Usage::whereNull('end_time')->count();
        $this->availableComputers = Computer::where('status', 'available')->count();
        $this->totalWarnings = Warning::count();

        $this->activeSessions = Usage::with(['user', 'computer'])
            ->whereNull('end_time')
            ->latest('start_time')
            ->get();

        $this->completedToday = Usage::with(['user', 'computer'])
            ->whereDate('start_time', now()->format('Y-m-d'))
            ->whereNotNull('end_time')
            ->latest('end_time')
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }

    public function forceEndSession($usageId)
    {
        $usage = Usage::with('computer')->findOrFail($usageId);

        if (is_null($usage->end_time)) {
            $usage->update(['end_time' => now()]);
            $usage->computer->update(['status' => 'available']);
        }

        $this->mount(); // Recarrega os dados
    }
}
