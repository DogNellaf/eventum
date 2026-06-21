<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_accessible(): void
    {
        $this->get('/login')->assertOk();
    }

    public function test_register_page_is_accessible(): void
    {
        $this->get('/register')->assertOk();
    }

    public function test_user_can_register(): void
    {
        $this->post('/register', [
            'name'                  => 'Тестовый Пользователь',
            'email'                 => 'test@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect('/home');

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_user_can_login(): void
    {
        $user = User::factory()->create(['password' => bcrypt('password123')]);

        $this->post('/login', [
            'email'    => $user->email,
            'password' => 'password123',
        ])->assertRedirect('/home');
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $user = User::factory()->create(['password' => bcrypt('correct')]);

        $this->post('/login', [
            'email'    => $user->email,
            'password' => 'wrong',
        ])->assertSessionHasErrors('email');
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirect('/');
    }

    public function test_register_validates_required_fields(): void
    {
        $this->post('/register', [])->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function test_register_validates_unique_email(): void
    {
        $user = User::factory()->create();

        $this->post('/register', [
            'name'                  => 'Другой пользователь',
            'email'                 => $user->email,
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ])->assertSessionHasErrors('email');
    }

    public function test_new_user_is_not_admin_by_default(): void
    {
        $this->post('/register', [
            'name'                  => 'Обычный пользователь',
            'email'                 => 'regular@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('email', 'regular@example.com')->first();
        $this->assertFalse((bool) $user->is_admin);
    }
}
