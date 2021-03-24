<?php

namespace Tests\Feature;

use App\Carousel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CarouselTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function create_a_carousel_and_see_it_in_the_db()
    {
        $carousel = factory(\App\Carousel::class)->create();

        $this->assertDatabaseHas('carousels', [
            'id' => $carousel->id
        ]);
    }

    /** @test */
    public function a_request_stores_a_carousel()
    {
        $carousel = factory(\App\Carousel::class)->make();

        $carouselName = $carousel->item_name;

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->json(
            'POST',
            'carousel/store',
            [
                'item_name' => $carousel->item_name,
                'item_description' => $carousel->item_description,
                'item_image' => $file,
            ]
        );

        $carousel = $carousel->attributesToArray();

        $response
            ->assertStatus(201);

        Storage::exists($file->hashName());

        $this->assertDatabaseHas('carousels', [
            'item_name' => $carouselName,
        ]);
    }


    /** @test */
    public function a_request_gets_carousel_index()
    {
        factory(Carousel::class, 25)->create();

        $carouselBase = Carousel::all();

        $response = $this->json(
            'GET',
            'carousel/index'
        );

        $carouselBase = $carouselBase->toArray();

        $response
            ->assertStatus(200)
            ->assertJson($carouselBase);
    }

    /** @test */
    public function a_request_gets_a_specific_carousel()
    {
        $carousel = factory(Carousel::class)->create();

        $response = $this->json(
            'POST',
            'carousel/show',
            [
                'id' => $carousel->id,
            ]
        );

        $carousel = $carousel->attributesToArray();

        $response
            ->assertStatus(200)
            ->assertJson($carousel);
    }

    /** @test */
    public function a_request_deletes_a_specific_carousel()
    {
        $carousel = factory(Carousel::class)->create();

        $carouselId = $carousel->id;

        $response = $this->json(
            'POST',
            'carousel/destroy',
            [
                'id' => $carousel->id,
            ]
        );

        $carousel = $carousel->attributesToArray();

        $response
            ->assertStatus(200)
            ->assertJson($carousel);

        $this->assertDeleted('carousels', [
            'id' => $carouselId
        ]);
    }

    /** @test */
    public function a_route_carousel_returns_view()
    {
        $response = $this->get('/carousel');

        $response
            ->assertStatus(200)
            ->assertViewIs('admin.carousel');
    }
}
