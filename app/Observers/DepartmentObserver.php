<?php

namespace App\Observers;

use App\Models\Department;

class DepartmentObserver
{
    /**
     * Handle the Department "deleting" event.
     */
    public function deleting(Department $department): void
    {
        $department->users()->detach();
    }
}
