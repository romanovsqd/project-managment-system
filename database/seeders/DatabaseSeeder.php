<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory(2)->create(['role' => 'manager']);

        $user->each(function ($user) {
            $project = Project::factory()->create([
                'created_by' => $user->id,
            ]);

            $user->memberProjects()->attach($project);

            $projectMembers = User::factory(5)->create();

            $projectMembers->each(function ($projectMember) use ($project) {
                $projectMember->memberProjects()->attach($project);
                Task::factory(2)->create([
                    'project_id' => $project->id,
                    'assigned_to' => $projectMember->id,
                ]);
            });
        });

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
