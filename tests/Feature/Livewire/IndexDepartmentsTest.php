<?php

namespace Tests\Feature\Livewire;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

use App\Models\User;
use App\Models\Department;
use App\Livewire\Departments\IndexDepartments;

class IndexDepartmentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        Livewire::test(IndexDepartments::class)
            ->assertStatus(200);
    }

    /** @test */
    public function component_department_can_be_deleted()
    {
        $department = Department::factory()->create(['name' => 'Test Department']);

        Livewire::test(IndexDepartments::class)
            ->call('deleteDepartment', $department);

        $departmentsCount = Department::count();
        $this->assertEquals(0, $departmentsCount);
    }
}
