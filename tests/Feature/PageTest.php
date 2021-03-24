<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Page;
use Illuminate\Support\Facades\Cache;


class PageTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp() : void
    {
        parent::setUp();

        //$this->signIn();
    }

    /**
     * A basic feature test example.
     * 
     * @return void
     */
    public function test_page_Model_and_Factory_Works()
    {
        $this->item = factory(\App\Page::class)->create();

        $this->assertDatabaseHas('pages', [
            'id' => $this->item->id
        ]);
    }

    /** @test */
    public function test_a_page_can_be_deleted()
    {
        $this->item = factory(\App\Page::class)->create();

        $this->assertDatabaseHas('pages', [
            'id' => $this->item->id
        ]);

        $card = Page::find($this->item->id);

        $card->delete();

        $this->assertDeleted('pages', [
            'id' => $this->item->id
        ]);
    }

    /** @test */
    public function test_page_controller_return_index_of_pages()
    {
        $this->item = factory(\App\Page::class, 3)->create();

        $page_index = Page::all()->toArray();

        $response = $this->get('/page/index');

        $response
            ->assertStatus(200)
            ->assertJson($page_index);
    }

    /** @test */
    public function test_page_controller_store()
    {
        $page = factory(\App\Page::class)->make();

        $response = $this->json('POST', '/page/store', 
            [
                'title' => $page->title,
                'body' => $page->body,
                'link' => $page->link
            ]
        );

        $page = $page->attributesToArray();

        $response
            ->assertStatus(201)
            ->assertJson($page);

        $this->assertDatabaseHas('pages', [
            'id' => $response->decodeResponseJson()['id']
        ]);
    }

    /** @test */
    public function test_page_controller_destroy()
    {
        $page = factory(\App\Page::class)->create();

        $response = $this->json('POST', '/page/destroy', 
            [
                'id' => $page->id
            ]
        );

        $response
            ->assertStatus(200);

        $this->assertDeleted('pages', [
            'id' => $page->id
        ]);
    }

    /** @test */
    public function test_page_controller_show()
    {
        $page = factory(\App\Page::class)->create();

        $response = $this->json('POST', '/page/show', 
            [
                'id' => $page->id
            ]
        );

        $page = $page->attributesToArray();

        $response
            ->assertStatus(200)
            ->assertJson($page);
    }
}
