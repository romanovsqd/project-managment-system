<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        User::factory(2)->create(['role' => 'manager']);

        User::factory()->create([
            'email' => 'admin@mail.com',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'email' => 'manager@mail.com',
            'role' => 'manager',
        ]);

        User::factory()->create([
            'email' => 'member@mail.com',
            'role' => 'member',
        ]);
    }
}
