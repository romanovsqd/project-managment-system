<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectMemberSeeder extends Seeder
{
    public function run(): void
    {
        Project::all()->each(function ($project) {
            $projectMembers = User::factory(5)->create();

            $projectMembers->each(function ($projectMember) use ($project) {
                $projectMember->memberProjects()->attach($project);

                Task::factory(2)->create([
                    'project_id' => $project->id,
                    'assigned_to' => $projectMember->id,
                ]);
            });
        });
    }
}
