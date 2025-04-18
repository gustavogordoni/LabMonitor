<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class StudentList extends Component
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
        $query = User::where('role', 'student');

        if ($this->searchColumn === 'all') {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            });
        } else {
            $query->where($this->searchColumn, 'like', "%{$this->search}%");
        }

        $students = $query->orderBy('name')->paginate(10);

        return view('livewire.admin.student-list', compact('students'));
    }
}
