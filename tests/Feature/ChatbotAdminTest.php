<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatbotAdminTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Unit Test: Admin Sync Endpoint
     */
    public function test_admin_sync_dialogflow_route_redirects_properly()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.chatbot.sync'));

        // It should perform its action and redirect back
        $response->assertStatus(302);
        
        // Assert it set a flash message
        $response->assertSessionHas('flash.banner');
    }
}
