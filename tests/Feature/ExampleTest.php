<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use App\http\Controllers\TestController;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(404);
    }

    public function test_to_add_payment_method()
    {
        $response = $this->post(route('addPays'));
        $this->assertEquals(302, $response->status());
    }

    public function test_to_remove_payment_method()
    {
        $response = $this->post(route('addPays'));
        $this->assertEquals(302, $response->status());

    }
}
