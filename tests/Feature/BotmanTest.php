<?php

namespace Tests\Feature;

use Tests\TestCase;

class BotmanTest extends TestCase
{
    /**
     * Smoke Test: Check if Botman responds properly.
     */
    public function test_botman_endpoint_is_reachable_and_returns_ok()
    {
        $response = $this->postJson('/botman', [
            'driver' => 'web',
            'message' => 'hello',
            'interactive' => 0
        ]);

        $response->assertStatus(200);
    }
}
