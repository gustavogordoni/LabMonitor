<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Computer;

class ComputerList extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $computers = Computer::where('label', 'like', '%' . $this->search . '%')
            ->orderBy('label')
            ->paginate(10);

        return view('livewire.admin.computer-list', compact('computers'));
    }
}
