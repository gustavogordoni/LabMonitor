<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Computer;

class ComputerList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Computer::query();

        if (!empty($this->search)) {
            $query->where('label', 'like', "%{$this->search}%");
        }

        $statusMap = [
            'disponível' => 'available',
            'em uso' => 'in_use',
            'indisponível' => 'inactive',
        ];

        $status = $statusMap[strtolower($this->statusFilter)] ?? $this->statusFilter;

        if (in_array($status, ['available', 'in_use', 'inactive'])) {
            $query->where('status', $status);
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
