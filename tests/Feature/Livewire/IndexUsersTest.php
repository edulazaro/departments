<?php

namespace Tests\Feature\Livewire;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

use App\Models\User;
use App\Models\Department;
use App\Livewire\Users\IndexUsers;

class IndexUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        Livewire::test(IndexUsers::class)
            ->assertStatus(200);
    }

    /** @test */
    public function component_user_can_be_deleted()
    {
        $user = User::factory()->create(['name' => 'Test User']);

        Livewire::test(IndexUsers::class)
            ->call('deleteUser', $user);

        $usersCount = User::count();
        $this->assertEquals(0, $usersCount);
    }
}
