<?php

namespace App\Livewire\Departments;

use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

use App\Models\Department;

class IndexDepartments extends Component
{
    public Collection $departments;

    public int $page = 1;
    public int $perPage = 10;
    public string|null $searchText = null;
    public bool $moreRecords = true;

    protected $listeners = [
        'addedDepartment' => 'getDepartments',
        'editedDepartment' => 'getDepartments'
    ];

    /**
     * Retrieve departments based on search criteria.
     *
     * Retrieves departments from the database based on the current search text
     * and sets the departments collection accordingly.
     *
     * @return void
     */
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

    /**
     * Perform initial setup when the component is mounted.
     *
     * Retrieves departments from the database and initializes the component's state.
     *
     * @return void
     */
    public function mount()
    {
        $this->getDepartments();
    }

    public function updatedSearchText()
    {
        $this->getDepartments();
    }

    /**
     * Delete a department.
     *
     * Deletes the specified department from the database and refreshes the departments list.
     *
     * @param  \App\Models\Department  $department The department to delete
     * @return void
     */
    public function deleteDepartment(Department $department)
    {
        $department->delete();
        $this->getDepartments();
    }

    /**
     * Load more departments and append them to the existing collection.
     *
     * This method increases the page number and retrieves additional departments based on the current page
     * and search criteria, and appending them to the existing departments collection.
     *
     * @return void
     */
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

    /**
     * Render the Livewire component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.departments.index-departments');
    }
}
