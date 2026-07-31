<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_disp_register_page(): void {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_register_user(): void {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(302);
    }

    public function test_disp_login_page(): void {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_login_user(): void {
        // 事前にユーザーを作成
        $user = \App\Models\User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $user->password,
        ]);

        $response->assertStatus(302);
    }
}
