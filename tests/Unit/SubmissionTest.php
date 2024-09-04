<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubmissionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test successful submission.
     *
     * @return void
     */
    public function testSuccessfulSubmission()
    {
        $response = $this->postJson('/v1/submissions', [
            'name' => 'TEST John Smith',
            'email' => 'john.smith@example.com',
            'message' => 'This is a test message.',
        ]);

        $response->assertStatus(202)
            ->assertJson(['message' => 'Submission received.']);
    }

    /**
     * Test missing name.
     *
     * @return void
     */
    public function testMissingName()
    {
        $response = $this->postJson('/v1/submissions', [
            'email' => 'john.smith@example.com',
            'message' => 'This is a test message.',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    /**
     * Test missing email.
     *
     * @return void
     */
    public function testMissingEmail()
    {
        $response = $this->postJson('/v1/submissions', [
            'name' => 'TEST John Smith',
            'message' => 'This is a test message.',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    /**
     * Test missing message.
     *
     * @return void
     */
    public function testMissingMessage()
    {
        $response = $this->postJson('/v1/submissions', [
            'name' => 'TEST John Smith',
            'email' => 'john.smith@example.com',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['message']);
    }

    /**
     * Test invalid email format.
     *
     * @return void
     */
    public function testInvalidEmailFormat()
    {
        $response = $this->postJson('/v1/submissions', [
            'name' => 'TEST John Smith',
            'email' => 'invalid-email',
            'message' => 'This is a test message.',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    /**
     * Test extra fields in request.
     *
     * @return void
     */
    public function testExtraFields()
    {
        $response = $this->postJson('/v1/submissions', [
            'name' => 'TEST John Smith',
            'email' => 'john.smith@example.com',
            'message' => 'This is a test message.',
            'extra_field' => 'Extra value',
        ]);

        $response->assertStatus(202)
            ->assertJson(['message' => 'Submission received.']);
    }

    /**
     * Test successful submission and job processing.
     *
     * @return void
     */
    public function testSubmissionAndJobProcessing()
    {
        $response = $this->postJson('/v1/submissions', [
            'name' => 'TEST John Black',
            'email' => 'john.black@example.com',
            'message' => 'This is a test message.',
        ]);

        $response->assertStatus(202)
            ->assertJson(['message' => 'Submission received.']);

         $this->artisan('queue:work', ['--once' => true]);

        $this->assertDatabaseHas('submissions', [
            'name' => 'TEST John Black',
            'email' => 'john.black@example.com',
            'message' => 'This is a test message.',
        ]);
    }

}
