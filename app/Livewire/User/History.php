<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Usage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class History extends Component
{
    public $usages;
    public $averageWeekly;
    public $averageMonthly;
    public $activeSession;

    public function mount()
    {
        $userId = Auth::id();
        
        $this->usages = Usage::with('computer')
            ->where('user_id', $userId)
            ->orderBy('start_time', 'desc')
            ->get();
        
        $this->activeSession = $this->usages->firstWhere('end_time', null);

        $this->averageWeekly = $this->calculateAverageTime(Carbon::now()->subDays(7));
        $this->averageMonthly = $this->calculateAverageTime(Carbon::now()->subDays(30));
    }

    private function calculateAverageTime($since)
    {
        $totalMinutes = Usage::where('user_id', Auth::id())
            ->whereNotNull('end_time')
            ->where('start_time', '>=', $since)
            ->get()
            ->reduce(function ($carry, $usage) {
                return $carry + Carbon::parse($usage->start_time)->diffInMinutes($usage->end_time);
            }, 0);

        $count = Usage::where('user_id', Auth::id())
            ->whereNotNull('end_time')
            ->where('start_time', '>=', $since)
            ->count();

        return $count > 0 ? round($totalMinutes / $count, 2) : 0;
    }

    public function render()
    {
        return view('livewire.user.history');
    }
}
