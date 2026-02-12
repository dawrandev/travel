<?php

namespace Tests\Feature;

use App\Models\Tour;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_booking_with_valid_data(): void
    {
        $tour = Tour::factory()->create();

        $response = $this->postJson('/api/bookings', [
            'tour_id' => $tour->id,
            'full_name' => 'John Doe',
            'max_people' => 2,
            'starting_date' => '2026-03-15',
            'ending_date' => '2026-03-20',
            'primary_phone' => '1234567890',
            'email' => 'Q7NlK@example.com',
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.full_name', 'John Doe');
    }

    public function test_booking_fails_without_required_fields(): void
    {
        $tour = Tour::factory()->create();

        $response = $this->postJson('/api/bookings', [
            'tour_id' => $tour->id,
            // 'full_name' => 'John Doe', // required
            'max_people' => 2,
            'starting_date' => '2026-03-15',
            'ending_date' => '2026-03-20',
            'primary_phone' => '1234567890',
            // 'email' => '', // required
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['full_name', 'email']);
    }

    public function test_booking_fails_nonexistent_tour(): void
    {
        $response = $this->postJson('/api/bookings', [
            'tour_id' => 9999,
            'full_name' => 'John Doe',
            'max_people' => 2,
            'starting_date' => '2026-03-15',
            'ending_date' => '2026-03-20',
            'primary_phone' => '1234567890',
            'email' => 'Q7NlK@example.com',
            'message' => 'Looking forward to this tour!',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['tour_id']);
    }

    public function test_booking_fails_past_dates(): void
    {
        $tour = Tour::factory()->create();

        $response = $this->postJson('/api/bookings', [
            'tour_id' => $tour->id,
            'full_name' => 'John Doe',
            'max_people' => 2,
            'starting_date' => '2020-01-01',
            'ending_date' => '2020-01-10',
            'primary_phone' => '1234567890',
            'email' => 'Q7NlK@example.com',
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['starting_date']);
    }

    public function test_booking_fails_with_invalid_email(): void
    {
        $tour = Tour::factory()->create();

        $response = $this->postJson('/api/bookings', [
            'tour_id' => $tour->id,
            'full_name' => 'John Doe',
            'max_people' => 2,
            'starting_date' => '2026-07-01',
            'ending_date' => '2026-07-10',
            'primary_phone' => '1234567890',
            'email' => 'invalid-email', // invalid email
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_booking_is_saved_to_database(): void
    {
        $tour = Tour::factory()->create();

        $response = $this->postJson('/api/bookings', [
            'tour_id' => $tour->id,
            'full_name' => 'John Doe',
            'max_people' => 2,
            'starting_date' => '2026-07-01',
            'ending_date' => '2026-07-10',
            'primary_phone' => '1234567890',
            'email' => 'Q7NlK@example.com',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('bookings', [
            'tour_id' => $tour->id,
            'full_name' => 'John Doe',
            'max_people' => 2,
            'primary_phone' => '1234567890',
            'email' => 'Q7NlK@example.com',
            'status' => 'pending',
        ]);
    }
}
