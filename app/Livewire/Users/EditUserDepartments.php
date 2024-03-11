<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

use App\Models\User;
use App\Models\Department;

class EditUserDepartments extends Component
{
    public User|null $user;
    public Collection $unassignedDepartments;

    public int $departmentId;

    protected $listeners = [
        'editUserDepartments' => 'editUserDepartments',
    ];

    /**
     * Perform initial setup when the Livewire component is mounted.
     *
     * Initializes the Livewire component's state with the provided user,
     * and retrieves the list of unassigned departments if a user is provided.
     *
     * @param  \App\Models\User|null  $user The user to initialize
     * @return void
     */
    public function mount($user = null)
    {
        $this->user = $user;

        if ($this->user) {
            $this->getUnassignedDepartments();
        }
    }

    /**
     * Retrieve unassigned departments for the user.
     *
     * Retrieves departments that are not assigned to the current user
     * and sets the unassigned departments collection accordingly.
     *
     * @return void
     */
    public function getUnassignedDepartments()
    {
        $this->unassignedDepartments = Department::whereDoesntHave('users', function ($query) {
            $query->where('user_id', $this->user->id);
        })->get();
    }

    /**
     * Edit user departments.
     *
     * Sets the user for editing, retrieves the list of unassigned departments,
     * and triggers the opening of the modal for editing user departments.
     *
     * @param  \App\Models\User  $user The user to edit departments for
     * @return void
     */
    public function editUserDepartments(User $user)
    {
        $this->user = $user;
        $this->getUnassignedDepartments();

        $this->dispatch('open-modal-departments');
    }

    /**
     * Add a department to the user's assigned departments.
     *
     * Attaches the specified department to the user's assigned departments
     * and refreshes the list of unassigned departments.
     *
     * @return void
     */
    public function addDepartment()
    {
        $this->user->departments()->attach($this->departmentId);
        $this->getUnassignedDepartments();
    }

    /**
     * Delete a department from the user's assigned departments.
     *
     * Detaches the specified department from the user's assigned departments
     * and refreshes the list of unassigned departments.
     *
     * @param  \App\Models\Department  $department The department to detach
     * @return void
     */
    public function deleteUserDepartment(Department $department)
    {
        $this->user->departments()->detach($department);
        $this->getUnassignedDepartments();
    }

    /**
     * Render the Livewire component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.users.edit-user-departments');
    }
}
