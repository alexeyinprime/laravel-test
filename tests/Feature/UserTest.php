<?php

namespace Tests\Feature;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_the_application_returns_a_successful_json(): void
    {
        $response = $this->getJson('/users');

        $response->assertStatus(200);
    }

    public function test_the_application_returns_a_json_wo_empty_desc(): void
    {
        $response = $this->getJson('/users');
        foreach ($response->json() as $key => $value) {
            $this->assertGreaterThanOrEqual(
                1,
                count($value['description']),
                "The User ID#{$value['id']} has empty description."
            );
        }

    }
}
