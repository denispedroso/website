<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class RedisTest extends TestCase
{

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
    public function test_Redis()
    {

        //Cache::put('key', 'value', 60);
        $data = [
            'event' => 'UserSignedUp',
            'data' => [
                'username' => 'JohnDoe'
            ]
        ];

        Redis::publish('test-channel', json_encode($data));

        Redis::set('bar', 'baz');
        //Cache::put('bar', 'baz', 600);

        $key = Redis::get('bar');

        $this->assertEquals('baz', $key);
    }

    /** @test */
    public function test_session()
    {
        session(['key' => 'value']);

        $value = session('key');

        $this->assertEquals('value', $value);
    }

    /** @test */
    public function testCookies()
    {
        $response = $this->get('/cookie');

        $response->assertCookie('color');
    }

    /** @test */
    public function test_items_in_session()
    {
        $response = $this->get('/cookie');

        $response->assertSessionHas('key', 'value')
            ->assertSuccessful();
    }
}
