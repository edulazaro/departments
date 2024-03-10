<?php

namespace App\Livewire\Users;

use Livewire\Component;

use App\Models\User;
use App\Models\Department;

class EditUserDepartments extends Component
{
    public $user;
    public $unassignedDepartments;

    public $departmentId;

    protected $listeners = [
        'editUserDepartments' => 'editUserDepartments',
    ];

    public function mount($user = null)
    {
        $this->user = $user;

        if ($this->user) {
            $this->getUnassignedDepartments();
        }
    }

    public function getUnassignedDepartments()
    {
        $this->unassignedDepartments = Department::whereDoesntHave('users', function ($query) {
            $query->where('user_id', $this->user->id);
        })->get();
    }

    public function editUserDepartments(User $user)
    {
        $this->user = $user;
        $this->getUnassignedDepartments();
    
        $this->dispatch('open-modal-departments');
    }

    public function addDepartment()
    {
        $this->user->departments()->attach($this->departmentId);
        $this->getUnassignedDepartments();
    }

    public function deleteUserDepartment(Department $department)
    {
        $this->user->departments()->detach($department);
        $this->getUnassignedDepartments();
    }

    public function render()
    {
        return view('livewire.users.edit-user-departments');
    }
}
