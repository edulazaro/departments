<?php

namespace Tests\Feature\Livewire;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

use App\Models\User;
use App\Models\Department;
use App\Livewire\Departments\AddDepartment;

class AddDepartmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        Livewire::test(AddDepartment::class)
            ->assertStatus(200);
    }

    /** @test */
    public function component_exists_on_the_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/departments')->assertSeeLivewire(AddDepartment::class);
    }

    /** @test */
    public function component_name_can_be_set()
    {
        Livewire::test(AddDepartment::class)
            ->set('name', 'Test Department')
            ->assertSet('name', 'Test Department');
    }

    /** @test */
    public function component_parent_department_can_be_set()
    {
        $department = Department::factory()->create();

        Livewire::test(AddDepartment::class)
            ->set('parentId', $department->id)
            ->assertSet('parentId', $department->id);
    }

    /** @test */
    public function component_department_not_created_if_invalid_name()
    {
        Livewire::test(AddDepartment::class)
            ->set('name', 'T')
            ->call('submit');

        $department = Department::first();

        $this->assertEquals(null, $department);
    }

    /** @test */
    public function component_department_not_created_if_invalid_parent_id()
    {
        Livewire::test(AddDepartment::class)
            ->set('name', 'Test Department')
            ->set('parentId', 80)
            ->call('submit');

        $department = Department::first();

        $this->assertEquals(null, $department);
    }

    /** @test */
    public function component_valid_submit_works()
    {
        $parentDepartment = Department::factory()->create();

        Livewire::test(AddDepartment::class)
            ->set('name', 'Test Department')
            ->set('parentId', $parentDepartment->id)
            ->call('submit');

        $department = Department::orderBy('id', 'DESC')->first();

        $this->assertEquals('Test Department', $department->name);
        $this->assertEquals($parentDepartment->id, $department->parent_id);
    }
}
