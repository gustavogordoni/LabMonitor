<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentDetails extends Component
{
    public User $user;
    public $confirmingStudentDeletion = false;
    public $adminPassword = '';
    public $deletionError = '';

    public function mount($userId)
    {
        $this->user = User::with(['usages.computer', 'warnings'])->findOrFail($userId);
    }

    public function confirmStudentDeletion()
    {
        $this->resetErrorBag();
        $this->adminPassword = '';
        $this->confirmingStudentDeletion = true;
    }

    public function deleteStudent()
    {
        if (!Hash::check($this->adminPassword, Auth::user()->password)) {
            $this->addError('adminPassword', 'Senha incorreta.');
            return;
        }

        $this->user->delete();
        
        return redirect()->route('admin.students');
    }

    public function render()
    {
        return view('livewire.admin.student-details');
    }
}
