<?php

namespace App\Livewire\Departments;

use Livewire\Component;

use App\Models\Department;

class IndexDepartments extends Component
{
    public $departments;

    public $page = 1;
    public $perPage = 10;
    public $searchText = null;
    public $moreRecords = true;

    protected $listeners = [
        'addedDepartment' => 'getDepartments',
        'editedDepartment' => 'getDepartments'
    ];

    public function getDepartments()
    {
        $this->moreRecords = true;

        $departmentsQuery = Department::query();
        
        if ($this->searchText) {
            $departmentsQuery->searchTextOn('name', $this->searchText);
        }

        $totalCount = $departmentsQuery->count();

        $this->departments = $departmentsQuery->latest()->limit($this->perPage)->get();

        if ($this->departments->count() >=  $totalCount) {
            $this->moreRecords = false;
        }
    }

    public function mount()
    {
        $this->getDepartments();
    }

    public function updatedSearchText()
    {
        $this->getDepartments();
    }

    public function deleteDepartment(Department $department)
    {
        $department->delete();
        $this->getDepartments();
    }

    public function loadMore()
    {
        $this->page += 1;

        $offset = ($this->page - 1) * $this->perPage;

        $departmentsQuery = Department::query();

        if ($this->searchText) {
            $departmentsQuery->searchTextOn('name', $this->searchText);
        }

        $totalCount = $departmentsQuery->count();
        $nextDepartments = $departmentsQuery->latest()->offset($offset)->limit($this->perPage)->get();

        $this->departments = $this->departments->concat($nextDepartments);

        if ($this->departments->count() >= $totalCount) {
            $this->moreRecords = false;
        }
    }

    public function render()
    {
        return view('livewire.departments.index-departments');
    }
}
