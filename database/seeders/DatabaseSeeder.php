<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Department;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Department::factory()->count(10)->create();
        Department::factory()->count(10)->withParent()->create();


        $departments = Department::all();

        User::factory()->count(20)->create()->each(function ($user) use ($departments) {

            if (!rand(0, 3)) return;

             $user->departments()->attach(
                 $departments->random(rand(1, 3))->pluck('id')->toArray()
            );

        });

        User::factory()->count(1)->create(['name' => 'admin', 'email' => 'test@test.com', 'password' => 'testpass', 'role' => 'admin']);
    }
}
