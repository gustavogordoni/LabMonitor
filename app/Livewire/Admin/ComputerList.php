<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Computer;

class ComputerList extends Component
{
    use WithPagination;

    public $search = '';
    public $searchColumn = 'all';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSearchColumn()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Computer::query();

        if ($this->searchColumn === 'all') {
            $query->where(function ($q) {
                $q->where('label', 'like', "%{$this->search}%")
                    ->orWhere('status', 'like', "%{$this->search}%");
            });
        } else {
            $query->where($this->searchColumn, 'like', "%{$this->search}%");
        }

        $computers = $query->orderBy('label')->paginate(10);

        return view('livewire.admin.computer-list', compact('computers'));
    }

    public function inactivateComputer($idComputer)
    {
        $computer = Computer::findOrFail($idComputer);

        $activeUsage = $computer->usages()
            ->whereNull('end_time')
            ->latest('start_time')
            ->first();

        if ($activeUsage) {
            $activeUsage->update(['end_time' => now()]);
        }

        $computer->update(['status' => 'inactive']);

        $this->resetPage();
    }

    public function availableComputer($idComputer)
    {
        $computer = Computer::findOrFail($idComputer);       

        $computer->update(['status' => 'available']);

        $this->resetPage();
    }
}
