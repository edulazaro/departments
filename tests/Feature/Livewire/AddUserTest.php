<?php

namespace Tests\Feature\Livewire;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

use App\Models\User;
use App\Livewire\Users\AddUser;

class AddUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        Livewire::test(AddUser::class)
            ->assertStatus(200);
    }

    /** @test */
    public function component_exists_on_the_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/users')->assertSeeLivewire(AddUser::class);
    }

    /** @test */
    public function component_name_can_be_set()
    {
        Livewire::test(AddUser::class)
            ->set('name', 'Test name')
            ->assertSet('name', 'Test name');
    }

    /** @test */
    public function component_email_can_be_set()
    {
        Livewire::test(AddUser::class)
            ->set('email', 'test@gmail.com')
            ->assertSet('email', 'test@gmail.com');
    }

    /** @test */
    public function component_user_not_created_if_invalid_email()
    {
        Livewire::test(AddUser::class)
            ->set('name', 'Test name')
            ->set('email', 'testail.com')
            ->call('submit');

        $user = User::first();

        $this->assertEquals(null, $user);
    }

    /** @test */
    public function component_user_not_created_if_invalid_name()
    {
        Livewire::test(AddUser::class)
            ->set('name', 'T')
            ->set('email', 'test@gmail.com')
            ->call('submit');

        $user = User::first();

        $this->assertEquals(null, $user);
    }

    /** @test */
    public function component_valid_submit_works()
    {
        Livewire::test(AddUser::class)
            ->set('name', 'Test name')
            ->set('email', 'test@gmail.com')
            ->call('submit');

        $user = User::first();

        $this->assertEquals('Test name', $user->name);
        $this->assertEquals('test@gmail.com', $user->email);
    }
}
