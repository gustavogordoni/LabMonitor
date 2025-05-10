<?php

namespace App\Livewire\Admin;

use App\Models\Computer;
use Livewire\Component;

class Room extends Component
{
    public $rooms = [];

    public $selectedRoomName;
    public $selectedComputers = [];
    public $showRoomModal = false;

    public $editingComputer;
    public $editLabel = '';
    public $editCode = '';

    public function mount()
    {
        $this->loadRooms();
    }

    public function loadRooms()
    {
        $this->rooms = Computer::select('room')
            ->groupBy('room')
            ->get()
            ->map(function ($room) {
                return [
                    'name' => $room->room,
                    'total' => Computer::where('room', $room->room)->count(),
                    'active' => Computer::where('room', $room->room)->where('status', 'available')->count(),
                    'inactive' => Computer::where('room', $room->room)->where('status', 'inactive')->count(),
                ];
            });
    }

    public function activateAll($room)
    {
        Computer::where('room', $room)
            ->where('status', 'inactive')
            ->update(['status' => 'available']);

        $this->loadRooms();
    }

    public function deactivateAll($room)
    {
        Computer::where('room', $room)
            ->where('status', 'available')
            ->update(['status' => 'inactive']);

        $this->loadRooms();
    }

    public function showRoomComputers($room)
    {
        $this->selectedRoomName = $room;
        $this->selectedComputers = Computer::where('room', $room)->get()->toArray();
        $this->showRoomModal = true;
    }

    public function startEdit($id)
    {
        $this->editingComputer = Computer::findOrFail($id);
        $this->editLabel = $this->editingComputer->label;
        $this->editCode = $this->editingComputer->code;
    }

    public function saveEdit()
    {
        $this->validate([
            'editLabel' => 'required|string|max:255',
            'editCode' => 'required|string|max:255|unique:computers,code,' . $this->editingComputer->id,
        ]);

        $this->editingComputer->update([
            'label' => $this->editLabel,
            'code' => $this->editCode,
        ]);

        $this->showRoomComputers($this->selectedRoomName);
        $this->editingComputer = null;
        $this->reset(['editLabel', 'editCode']);
    }

    public function deleteComputer($id)
    {
        Computer::findOrFail($id)->delete();
        $this->showRoomComputers($this->selectedRoomName);
        $this->loadRooms();
    }

    public function cancelEdit()
    {
        $this->editingComputer = null;
        $this->reset(['editLabel', 'editCode']);
        $this->showRoomComputers($this->selectedRoomName);
    }

    public function render()
    {
        return view('livewire.admin.room');
    }
}
