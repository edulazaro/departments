<?php

namespace Tests\Feature\Livewire;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

use App\Models\User;
use App\Models\Department;
use App\Livewire\Users\EditUserDepartments;

class EditUserDepartmentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        Livewire::test(EditUserDepartments::class)
            ->assertStatus(200);
    }

    /** @test */
    public function component_user_can_be_set()
    {
        $user = User::factory()->create(['name' => 'Test Department']);

        Livewire::test(EditUserDepartments::class)
            ->call('editUserDepartments', $user)
            ->assertSet('user.name', 'Test Department');
    }

    /** @test */
    public function component_department_id_can_be_set()
    {
        $user = User::factory()->create();
        $department = Department::factory()->create();

        Livewire::test(EditUserDepartments::class)
            ->call('editUserDepartments', $user)
            ->set('departmentId', $department->id)
            ->assertSet('departmentId', $department->id);
    }


    /** @test */
    public function component_add_department_works()
    {
        $department = Department::factory()->create(['name' => 'Test Department']);
        $user = User::factory()->create();

        Livewire::test(EditUserDepartments::class)
            ->call('editUserDepartments', $user)
            ->set('departmentId', $department->id)
            ->call('addDepartment');

        $userDepartmentsCount = $user->departments()->count();
        $userDepartment = $user->departments()->first();

        $this->assertEquals('Test Department', $userDepartment->name);
        $this->assertEquals(1, $userDepartmentsCount);
    }

    /** @test */
    public function component_delete_department_works()
    {
        $department = Department::factory()->create(['name' => 'Test Department']);
        $user = User::factory()->create();

        Livewire::test(EditUserDepartments::class)
            ->call('editUserDepartments', $user)
            ->set('departmentId', $department->id)
            ->call('addDepartment')
            ->call('deleteUserDepartment', $department);

        $userDepartmentsCount = $user->departments()->count();
        $this->assertEquals(0, $userDepartmentsCount);
    }
}
