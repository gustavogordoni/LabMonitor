<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;

class UserDetails extends Component
{
    public User $user;

    public function mount($userId)
    {
        $this->user = User::with(['usages.computer', 'warnings'])->findOrFail($userId);
    }
    
    public function render()
    {        
        return view('livewire.admin.user-details');
    }
}
