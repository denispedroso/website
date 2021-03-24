<?php

namespace Tests\Feature;

use App\Brand;
use App\Product;
use App\Type;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BrandTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function create_a_brand_and_see_it_in_the_db()
    {
        $brand = factory(Brand::class)->create();

        $this->assertDatabaseHas('brands', [
            'id' => $brand->id
        ]);
    }

    /** @test */
    public function a_brand_has_many_products()
    {
        factory(Product::class, 20)->create();

        $brand = Brand::all()->first();

        $brand_products = $brand->products;

        $products = Product::where('brand_id', $brand->id);

        $this->assertEquals($brand_products->count(), $products->count());
    }

    /** @test */
    public function a_request_stores_a_brand()
    {
        $brand = factory(Brand::class)->make();

        $brandName = $brand->name;

        $response = $this->json(
            'POST',
            'brand/store',
            [
                'name' => $brand->name,
            ]
        );

        $brand = $brand->attributesToArray();

        $response
            ->assertStatus(201)
            ->assertJson($brand);

        $this->assertDatabaseHas('brands', [
            'name' => $brandName,
        ]);
    }


    /** @test */
    public function a_request_gets_Brand_index()
    {
        factory(Brand::class, 25)->create();

        $brandBase = Brand::all();

        $response = $this->json(
            'GET',
            'brand/index'
        );

        $brandBase = $brandBase->toArray();

        $response
            ->assertStatus(200)
            ->assertJson($brandBase);
    }

    /** @test */
    public function a_request_gets_a_specific_Brand()
    {
        $brand = factory(Brand::class)->create();

        $response = $this->json(
            'POST',
            'brand/show',
            [
                'id' => $brand->id,
            ]
        );

        $brand = $brand->attributesToArray();

        $response
            ->assertStatus(200)
            ->assertJson($brand);
    }

    /** @test */
    public function a_request_deletes_a_specific_Brand()
    {
        $brand = factory(Brand::class)->create();

        $brandId = $brand->id;

        $response = $this->json(
            'POST',
            'brand/destroy',
            [
                'id' => $brand->id,
            ]
        );

        $brand = $brand->attributesToArray();

        $response
            ->assertStatus(200)
            ->assertJson($brand);

        $this->assertDeleted('brands', [
            'id' => $brandId
        ]);
    }

    /** @test */
    public function a_route_brand_returns_view()
    {
        $response = $this->get('/brand');

        $response
            ->assertStatus(200)
            ->assertViewIs('admin.brand');
    }
}
