<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class NavTest extends TestCase
{

    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        //$this->signIn();
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_routes_controller()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->json('get', '/nav/index');

        $this->assertAuthenticated();

        $response->assertStatus(200)
            ->dump();
    }
}
