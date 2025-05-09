<?php

namespace App\Livewire\Admin;

use App\Models\Computer;
use Livewire\Component;

class Room extends Component
{
    public $rooms = [];

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

    public function render()
    {
        return view('livewire.admin.room');
    }
}
