<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_admin_can_create_user(): void
    {
        $roles = ['manager', 'member'];

        $credentials = [
            'name' => 'Jhon',
            'email' => 'jhon@example.com',
            'password' => 'password',
            'role' => 'manager',
            'password_confirmation' => 'password',
        ];

        foreach ($roles as $role) {
            $user = User::factory()->create([
                'role' => $role,
            ]);

            Sanctum::actingAs($user);

            $response = $this->postJson(route('users.store'), $credentials);
            $response->assertStatus(403);
        }

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        Sanctum::actingAs($admin);

        $response = $this->postJson(route('users.store'), $credentials);
        $response->assertStatus(201);
    }

    public function test_only_admin_can_get_all_users(): void
    {
        $roles = ['manager', 'member'];

        foreach ($roles as $role) {
            $user = User::factory()->create([
                'role' => $role,
            ]);

            Sanctum::actingAs($user);

            $response = $this->getJson(route('users.index'));
            $response->assertStatus(403);
        }

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        Sanctum::actingAs($admin);

        $response = $this->getJson(route('users.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_delete_user(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $user = User::factory()->create();

        Sanctum::actingAs($admin);

        $response = $this->deleteJson(route('users.destroy', $user));
        $response->assertStatus(200);
    }
}
