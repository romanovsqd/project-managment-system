<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'manager')->get();

        $users->each(function ($user) {
            $project = Project::factory()->create([
                'created_by' => $user->id,
            ]);

            $user->memberProjects()->attach($project);
        });
    }
}
