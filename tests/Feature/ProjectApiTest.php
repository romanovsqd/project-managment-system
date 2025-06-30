<?php

namespace Tests\Feature;

use App\Models\Project;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_and_manager_can_create_project(): void
    {
        $roles = ['admin', 'manager'];

        $projectData = [
            'name' => 'project title',
            'description' => 'project description',
        ];

        foreach ($roles as $role) {
            $user = User::factory()->create([
                'role' => $role,
            ]);

            Sanctum::actingAs($user);

            $response = $this->postJson(route('projects.store'), $projectData);
            $response->assertStatus(201);
        }
    }

    public function test_manager_can_edit_own_project(): void
    {
        $projectData = [
            'name' => 'project title',
            'description' => 'project description',
            'status' => 'completed',
        ];

        $manager = User::factory()->create([
            'role' => 'manager',
        ]);

        $project = Project::factory()->create([
            'created_by' => $manager->id,
        ]);

        Sanctum::actingAs($manager);

        $response = $this->putJson(route('projects.update', $project), $projectData);
        $response->assertStatus(200);
    }

    public function test_manager_can_add_member_to_project(): void
    {
        $manager = User::factory()->create([
            'role' => 'manager',
        ]);

        $project = Project::factory()->create([
            'created_by' => $manager->id,
        ]);

        $user = User::factory()->create();

        Sanctum::actingAs($manager);

        $response = $this->postJson(route('projects.users.store', $project), [
            'user_id' => $user->id,
        ]);
        $response->assertStatus(200);
    }

    public function test_member_cannot_create_project(): void
    {
        $projectData = [
            'name' => 'project title',
            'description' => 'project description',
        ];

        $user = User::factory()->create([
            'role' => 'member',
        ]);

        Sanctum::actingAs($user);

        $response = $this->postJson(route('projects.store'), $projectData);
        $response->assertStatus(403);
    }
}
