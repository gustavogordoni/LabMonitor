<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Computer;
use App\Models\Usage;
use App\Models\User;

class ComputerList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';

    public $searchUser = '';
    public $selectedUserId = null;
    public $selectedUserName = null;

    public $selectedComputerId = null;
    public $showUserModal = false;

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

    public function openUserModal($computerId)
    {
        $this->selectedComputerId = $computerId;
        $this->showUserModal = true;
        $this->reset(['searchUser', 'selectedUserId', 'selectedUserName']);
    }

    public function createManualSession()
    {
        $this->validate([
            'selectedUserId' => 'required|exists:users,id',
            'selectedComputerId' => 'required|exists:computers,id',
        ]);

        $computer = Computer::findOrFail($this->selectedComputerId);

        if ($computer->status !== 'available') {
            session()->flash('error', 'Computador não está disponível.');
            return;
        }

        $existingUsage = Usage::where('user_id', $this->selectedUserId)
            ->whereNull('end_time')
            ->first();

        if ($existingUsage) {
            session()->flash('error', 'Este usuário já possui uma sessão ativa.');
            return;
        }

        Usage::create([
            'user_id' => $this->selectedUserId,
            'computer_id' => $computer->id,
            'start_time' => now(),
        ]);

        $computer->update(['status' => 'in_use']);

        $this->reset(['selectedUserId', 'selectedComputerId', 'selectedUserName', 'searchUser', 'showUserModal']);
        $this->resetPage();
    }

    public function getFilteredUsersProperty()
    {
        if (strlen($this->searchUser) < 2) {
            return [];
        }

        return User::where('name', 'like', "%{$this->searchUser}%")
            ->where('role', 'student')
            ->orderBy('name')
            ->limit(10)
            ->get();
    }

    public function selectUser($userId)
    {
        $user = User::findOrFail($userId);
        $this->selectedUserId = $user->id;
        $this->selectedUserName = $user->name;
        $this->searchUser = $user->name;
    }
}