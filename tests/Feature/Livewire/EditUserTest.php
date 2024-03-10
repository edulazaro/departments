<?php

namespace Tests\Feature\Livewire;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

use App\Models\User;
use App\Models\Department;
use App\Livewire\Users\EditUser;

class EditUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        Livewire::test(EditUser::class)
            ->assertStatus(200);
    }

    /** @test */
    public function component_user_can_be_set()
    {
        $user = User::factory()->create(['name' => 'Test User']);

        Livewire::test(EditUser::class)
            ->call('editUser', $user)
            ->assertSet('name', 'Test User');
    }

    /** @test */
    public function component_name_can_be_set()
    {
        $user = User::factory()->create();

        Livewire::test(EditUser::class)
            ->call('editUser', $user)
            ->set('name', 'Test User')
            ->assertSet('name', 'Test User');
    }

    /** @test */
    public function component_email_can_be_set()
    {
        $user = User::factory()->create();

        Livewire::test(EditUser::class)
            ->call('editUser', $user)
            ->set('email', 'test@email.com')
            ->assertSet('email', 'test@email.com');
    }

    /** @test */
    public function component_user_not_saved_if_invalid_name()
    {
        $user = User::factory()->create();

        Livewire::test(EditUser::class)
            ->call('editUser', $user)
            ->set('name', 'T')
            ->call('submit');

        $user = User::first();

        $this->assertNotEquals('T', $user->name);
    }

    /** @test */
    public function component_user_not_saved_if_invalid_email()
    {
        $user = User::factory()->create();

        Livewire::test(EditUser::class)
            ->call('editUser', $user)
            ->set('email', 'tesmail.com')
            ->call('submit');

        $user = User::first();

        $this->assertNotEquals('tesmail.com', $user->email);
    }

    /** @test */
    public function component_valid_submit_works()
    {
        $user = User::factory()->create();

        Livewire::test(EditUser::class)
            ->call('editUser', $user)
            ->set('name', 'Test User')
            ->set('email', 'test@mail.com')
            ->call('submit');

        $user = User::first();

        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@mail.com', $user->email);
    }
}