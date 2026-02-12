<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase; // Har test dan keyin database o'zartiladi

    /**
     * ✅ TEST 1: Foydalanuvchi login sahifasini ko'rishi mumkin
     */
    public function test_user_can_view_login_page(): void
    {
        // Arrange: Hech qanday tayorlash kerak emas

        // Act: Login sahifasiga so'rov (route at '/')
        $response = $this->get('/');

        // Assert: Status 200 (ok) bo'lsa, test passed
        $response->assertStatus(200);
    }

    /**
     * ✅ TEST 2: Foydalanuvchi to'g'ri login/password bilan kirishi mumkin
     */
    public function test_user_can_login_with_valid_credentials(): void
    {
        // Arrange: Foydalanuvchi yaratamiz
        $user = User::factory()->create([
            'login' => 'testuser',
            'password' => bcrypt('Parol123'), // hashlangan parol
        ]);

        // Act: Login qilamiz
        $response = $this->post('/login', [
            'login' => 'testuser',
            'password' => 'Parol123', // normal parol (request da)
        ]);

        // Assert: Dashboard ga redirect bo'ladi (302 status)
        $response->assertRedirect('/dashboard');

        // Kirgan foydalanuvchi haqiqatan auth bo'lganini tekshiramiz
        $this->assertAuthenticatedAs($user);
    }

    /**
     * ❌ TEST 3: Noto'g'ri password bilan kirish mumkin emas
     */
    public function test_user_cannot_login_with_invalid_password(): void
    {
        // Arrange: Foydalanuvchi
        User::factory()->create([
            'login' => 'testuser',
            'password' => bcrypt('Parol123'),
        ]);

        // Act: Noto'g'ri parol bilan
        $response = $this->post('/login', [
            'login' => 'testuser',
            'password' => 'NotogriBir',
        ]);

        // Assert: Orqaga qaytadi
        $response->assertRedirect();

        // Auth bo'lmagan bo'lsa test passed
        $this->assertGuest();
    }

    /**
     * ❌ TEST 4: Mavjud bo'lmagan foydalanuvchi bilan kirish mumkin emas
     */
    public function test_user_cannot_login_with_nonexistent_login(): void
    {
        // Act: Mavjud bo'lmagan login
        $response = $this->post('/login', [
            'login' => 'mavjudbolmagan',
            'password' => 'Parol123',
        ]);

        // Assert: Kirish bo'lmadi
        $this->assertGuest();
        $response->assertRedirect();
    }

    /**
     * ✅ TEST 5: Foydalanuvchi logout qila oladi
     */
    public function test_user_can_logout(): void
    {
        // Arrange: Admin user (ID = 1) yaratamiz
        // AdminMiddleware faqat Auth::id() === 1 ni ruxsat beradi
        $user = User::factory()->create([
            'id' => 1, // Admin ID
            'login' => 'testuser',
            'password' => bcrypt('Parol123'),
        ]);

        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
        // Act: Logout qilamiz
        $response = $this->post('/logout');

        // Assert: Home sahifasiga redirect bo'ldi
        $response->assertRedirect('/');

        // Logout bo'lganini tekshiramiz
        $this->assertGuest();
    }

    /**
     * ❌ TEST 6: Validation - Empty login
     */
    public function test_login_validation_fails_without_login(): void
    {
        // Act: Login yo'q
        $response = $this->post('/login', [
            'login' => '',
            'password' => 'Parol123',
        ]);

        // Assert: Orqaga, validation error bilan
        $response->assertRedirect();
        $response->assertSessionHasErrors('login');
    }

    /**
     * ❌ TEST 7: Validation - Weak password
     */
    public function test_login_validation_fails_with_weak_password(): void
    {
        // Act: Parol to'liq emas
        $response = $this->post('/login', [
            'login' => 'testuser',
            'password' => 'weak', // 8 ta belgidan kam, raqam yo'q
        ]);

        // Assert: Validation error
        $response->assertRedirect();
        $response->assertSessionHasErrors('password');
    }
}
