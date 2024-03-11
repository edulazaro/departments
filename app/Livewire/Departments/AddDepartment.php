<?php

namespace App\Livewire\Departments;

use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

use App\Models\Department;

class AddDepartment extends Component
{
    public string $name;
    public int|null $parentId = null;

    public Collection $departments;

    /**
     * Define the validation rules for the Livewire component.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'name' => 'required|min:2',
            'parentId' => 'nullable|exists:' . Department::class . ',id',
        ];
    }

    /**
     * Perform initial setup when the Livewire component is mounted.
     *
     * Retrieves the list of departments from the database and initializes the Livewire component's state.
     *
     * @return void
     */
    public function mount()
    {
        $this->departments = Department::get();
    }

    /**
     * Process form submission to create a new department.
     *
     * @return void
     */
    public function submit()
    {
        $this->validate();

        $department = new Department();
        $department->name = $this->name;
        $department->parent_id = $this->parentId;
        $department->save();

        $this->departments = Department::get();

        $this->name = '';
        $this->parentId = null;

        $this->dispatch('close-modal');
        $this->dispatch('addedDepartment');
    }

    /**
     * Render the Livewire component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.departments.add-department');
    }
}
