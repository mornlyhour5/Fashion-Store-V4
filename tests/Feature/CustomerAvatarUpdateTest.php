<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerAvatarUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_route_is_available_for_redirects(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
    }

    public function test_unauthenticated_user_cannot_update_avatar(): void
    {
        $user = User::create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'password' => bcrypt('secret123'),
            'role' => 'customer',
            'is_active' => true,
            'avata' => 'old-avatar.png',
        ]);

        $response = $this->putJson("/api/customersProfile/{$user->id}", [
            'avata' => 'new-avatar.png',
        ]);

        $response->assertStatus(401)
            ->assertJsonFragment([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function test_authenticated_user_can_update_own_avatar(): void
    {
        $user = User::create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'password' => bcrypt('secret123'),
            'role' => 'customer',
            'is_active' => true,
            'avata' => 'old-avatar.png',
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->putJson("/api/customersProfile/{$user->id}", [
                'avata' => 'new-avatar.png',
            ]);

        $response->assertOk();
        $this->assertSame('new-avatar.png', $user->fresh()->avata);
    }
}
