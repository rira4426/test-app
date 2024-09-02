<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterMobileTest extends TestCase
{
    /**
     * the request must be complete.
     */
    public function test_the_register_verify_invalid_request_response(): void
    {
        $response = $this->get('/register-verify');

        $response->assertStatus(302);
    }

    public function test_with_correct_input(): void
    {
        $response = $this->get('/register-verify',['mobile'=>'555', 'country_code'=>'01']);

        $response->assertStatus(200);
    }
}
