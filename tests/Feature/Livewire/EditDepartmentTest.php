<?php

namespace Tests\Feature\Livewire;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

use App\Models\Department;
use App\Livewire\Departments\EditDepartment;

class EditDepartmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        Livewire::test(EditDepartment::class)
            ->assertStatus(200);
    }

    /** @test */
    public function component_department_can_be_set()
    {
        $department = Department::factory()->create(['name' => 'Test Department']);

        Livewire::test(EditDepartment::class)
            ->call('editDepartment', $department)
            ->assertSet('name', 'Test Department');
    }

    /** @test */
    public function component_name_can_be_set()
    {
        $department = Department::factory()->create();

        Livewire::test(EditDepartment::class)
            ->call('editDepartment', $department)
            ->set('name', 'Test Department')
            ->assertSet('name', 'Test Department');
    }

    /** @test */
    public function component_parent_id_can_be_set()
    {
        $parentDepartment = Department::factory()->create();
        $department = Department::factory()->create();

        Livewire::test(EditDepartment::class)
            ->call('editDepartment', $department)
            ->set('parentId', $parentDepartment->id)
            ->assertSet('parentId', $parentDepartment->id);
    }

    /** @test */
    public function component_department_not_saved_if_invalid_name()
    {
        $department = Department::factory()->create();

        Livewire::test(EditDepartment::class)
            ->call('editDepartment', $department)
            ->set('name', 'T')
            ->call('submit');

        $department = Department::first();

        $this->assertNotEquals('T', $department->name);
    }

    /** @test */
    public function component_department_not_saved_if_same_parent_id()
    {
        $department = Department::factory()->create();

        Livewire::test(EditDepartment::class)
            ->call('editDepartment', $department)
            ->set('parentId', $department->id)
            ->call('submit');

        $department = Department::first();

        $this->assertNotEquals($department->id, $department->parent_id);
    }

    /** @test */
    public function component_department_not_saved_if_invalid_parent_id()
    {
        $department = Department::factory()->create();

        Livewire::test(EditDepartment::class)
            ->call('editDepartment', $department)
            ->set('parentId', 888)
            ->call('submit');

        $department = Department::first();

        $this->assertNotEquals(888, $department->parent_id);
    }

    /** @test */
    public function component_valid_submit_works()
    {
        $parentDepartment = Department::factory()->create();
        $department = Department::factory()->create();

        Livewire::test(EditDepartment::class)
            ->call('editDepartment', $department)
            ->set('name', 'Test Department')
            ->set('parentId', $parentDepartment->id)
            ->call('submit');

        $department = Department::orderBy('id', 'DESC')->first();

        $this->assertEquals('Test Department', $department->name);
        $this->assertEquals($parentDepartment->id, $department->parent_id);
    }

    /** @test */
    public function component_detach_child_department_works()
    {
        $parentDepartment = Department::factory()->create();
        $department = Department::factory()->create(['parent_id' => $parentDepartment->id]);

        $childDepartmentsCount = $parentDepartment->child()->count();
        $this->assertEquals($childDepartmentsCount, 1);

        Livewire::test(EditDepartment::class)
            ->call('editDepartment', $parentDepartment)
            ->call('detachChildDepartment', $department);

        $childDepartmentsCount = $parentDepartment->child()->count();
        $this->assertEquals($childDepartmentsCount, 0);
    }
}
