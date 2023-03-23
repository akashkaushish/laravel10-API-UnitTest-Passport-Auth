<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    
    /**
     * A feature test for User Login through API.
     */
    public function test_api_login_load(): void
    {
        $response = $this->postJson('/api/login', ['email' => 'admin@gmail.com', 'password' => '123456']);
        $token = $response->json()['token'];
        $response
            ->assertStatus(200);
    }

    /**
     * A feature test to get Logged In User.
     */
    public function test_api_get_user(): void
    {
        $response = $this->postJson('/api/login', ['email' => 'admin@gmail.com', 'password' => '123456']);
        $token = $response->json()['token'];

        $response = $this->withHeaders(['Authorization' => "Bearer  $token"])
            ->json('GET', '/api/user');
        
        $response
            ->assertStatus(200);
    }

    /**
     * A feature test for User Logout through API.
     */
    public function test_api_user_logout(): void
    {
        $response = $this->postJson('/api/login', ['email' => 'admin@gmail.com', 'password' => '123456']);
        $token = $response->json()['token'];

        $response = $this->withHeaders(['Authorization' => "Bearer  $token"])
            ->json('GET', '/api/logout');
        
            $response
            ->assertStatus(200)
            ->assertExactJson([
                'data' => "Unauthorized",
                'message' => "User logout successfully.",
            ]);
    }

    
}
