<?php

namespace App\Livewire\Departments;

use Livewire\Component;

use App\Models\Department;

class EditDepartment extends Component
{
    public $name;
    public $parentId;

    public $department;
    public $departments;

    protected $listeners = [
        'editDepartment' => 'editDepartment',
    ];

    protected function rules()
    {
        return [
            'name' => 'required|min:2',
            'parentId' => 'nullable|sometimes|exists:' . Department::class . ',id|not_in:' . $this->department->id,
        ];
    }

    public function mount($department = null)
    {
        $this->$department = $department;
        $this->departments = Department::get();
    }

    public function editDepartment(Department $department)
    {
        $this->department = $department;

        $this->name = $this->department->name;
        $this->parentId = $this->department->parent_id;

        $this->dispatch('open-modal');
    }

    public function detachChildDepartment(Department $department)
    {
        $department->parent_id = null;
        $department->save();
    }

    public function submit()
    {
        $this->validate();

        $this->department->name = $this->name;
        $this->department->parent_id = $this->parentId ? $this->parentId : null;
        $this->department->save();

        $this->dispatch('close-modal');
        $this->dispatch('editedDepartment');
    }

    public function render()
    {
        if (!$this->department) {
            $this->skipRender();
        }

        return view('livewire.departments.edit-department');
    }
}
