<?php

namespace Tests\Feature;

use App\Models\Tour;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_question_with_valid_data(): void
    {
        $tour = Tour::factory()->create();

        $response = $this->postJson('/api/questions', [
            'tour_id' => $tour->id,
            'full_name' => 'John Doe',
            'phone' => '+998933651302',
            'email' => 'dawrandev@gmail.com',
            'comment' => 'This is a test question.',
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.full_name', 'John Doe');
    }

    public function test_question_fails_without_required_fields(): void
    {
        $tour = Tour::factory()->create();

        $response = $this->postJson('/api/questions', [
            'tour_id' => $tour->id,
            'phone' => '+998933651302',
            'comment' => 'This is a test question.',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'full_name',
            'email',
        ]);
    }

    public function test_question_fails_with_nonexistent_tour(): void
    {
        $response = $this->postJson('/api/questions', [
            'tour_id' => 9999,
            'full_name' => 'John Doe',
            'phone' => '+998933651302',
            'email' => 'dawrandev@gmail.com',
            'comment' => 'This is a test question.',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['tour_id']);
    }

    public function test_question_fails_with_invalid_email(): void
    {
        $tour = Tour::factory()->create();

        $response = $this->postJson('/api/questions', [
            'tour_id' => $tour->id,
            'full_name' => 'John Doe',
            'phone' => '+998933651302',
            'email' => 'invalid-email',
            'comment' => 'This is a test question.',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_question_fails_when_comment_exceeds_limit(): void
    {
        $tour = Tour::factory()->create();

        $longcomment = str_repeat('A', 2001);

        $response = $this->postJson('/api/questions', [
            'tour_id' => $tour->id,
            'full_name' => 'John Doe',
            'phone' => '+998933651302',
            'email' => 'dawrandev@gmail.com',
            'comment' => $longcomment,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['comment']);
    }

    public function test_question_is_saved_to_database_with_pending_status(): void
    {
        $tour = Tour::factory()->create();

        $response = $this->postJson('/api/questions', [
            'tour_id' => $tour->id,
            'full_name' => 'John Doe',
            'phone' => '+998933651302',
            'email' => 'dawrandev@gmail.com',
            'comment' => 'This is a test question.',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('questions', [
            'tour_id' => $tour->id,
            'full_name' => 'John Doe',
            'phone' => '+998933651302',
            'email' => 'dawrandev@gmail.com',
            'comment' => 'This is a test question.',
            'status' => 'pending',
        ]);
    }
}
