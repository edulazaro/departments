<?php

namespace App\Livewire\Departments;

use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

use App\Models\Department;

class EditDepartment extends Component
{
    public string $name;
    public int|null $parentId;

    public Department|null $department;
    public Collection $departments;

    protected $listeners = [
        'editDepartment' => 'editDepartment',
    ];

    /**
     * Define the validation rules for the Livewire component.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'name' => 'required|min:2',
            'parentId' => 'nullable|sometimes|exists:' . Department::class . ',id|not_in:' . $this->department->id,
        ];
    }

    /**
     * Perform initial setup when the Livewire component is mounted.
     *
     * Initializes the Livewire component's state, including the provided department,
     * and retrieves the list of departments from the database.
     *
     * @param  \App\Models\Department|null  $department The department to initialize
     * @return void
     */
    public function mount($department = null)
    {
        $this->$department = $department;
        $this->departments = Department::get();
    }

    /**
     * Edit a department.
     *
     * Sets the current department for editing, initializes form fields with department data,
     * and triggers the opening of the modal for editing.
     *
     * @param  \App\Models\Department  $department The department to edit
     * @return void
     */
    public function editDepartment(Department $department)
    {
        $this->department = $department;

        $this->name = $this->department->name;
        $this->parentId = $this->department->parent_id;

        $this->dispatch('open-modal');
    }

    /**
     * Detach a child department from its parent.
     *
     * Sets the parent_id of the specified department to null and saves the changes.
     *
     * @param  \App\Models\Department  $department The department to detach
     * @return void
     */
    public function detachChildDepartment(Department $department)
    {
        $department->parent_id = null;
        $department->save();
    }

    /**
     * Process form submission to edit a department.
     *
     * @return void
     */
    public function submit()
    {
        $this->validate();

        $this->department->name = $this->name;
        $this->department->parent_id = $this->parentId ? $this->parentId : null;
        $this->department->save();

        $this->dispatch('close-modal');
        $this->dispatch('editedDepartment');
    }

    /**
     * Render the Livewire component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.departments.edit-department');
    }
}
