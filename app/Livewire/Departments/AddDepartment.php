<?php

namespace App\Livewire\Departments;

use Livewire\Component;

use App\Models\Department;

class AddDepartment extends Component
{
    public $name;
    public $parentId;

    public $departments;

    protected function rules()
    {
        return [
            'name' => 'required|min:2',
            'parentId' => 'nullable|exists:' . Department::class . ',id',
        ];
    }

    public function mount()
    {
        $this->departments = Department::get();
    }

    public function submit()
    {
        $this->validate();

        $department = new Department();
        $department->name = $this->name;
        $department->parent_id = $this->parentId;
        $department->save();

        $this->departments = Department::get();

        $this->dispatch('close-modal');
        $this->dispatch('addedDepartment');
    }

    public function render()
    {
        return view('livewire.departments.add-department');
    }
}
