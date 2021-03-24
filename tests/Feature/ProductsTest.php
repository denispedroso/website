<?php

namespace Tests\Feature;

use App\Brand;
use App\Product;
use App\Type;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function create_a_product_and_see_it_in_the_db()
    {
        $product = factory(Product::class)->create();

        $this->assertDatabaseHas('products', [
            'id' => $product->id
        ]);
    }

    /** @test */
    public function gets_a_type_and_brand_from_a_product()
    {
        $product = factory(Product::class)->create();

        $type = $product->type;

        $brand = $product->brand;

        $this->assertEquals($type->id, $product->type_id);

        $this->assertEquals($brand->id, $product->brand_id);
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
    public function a_type_has_many_products()
    {
        factory(Product::class, 20)->create();

        $type = Type::all()->first();

        $type_products = $type->products;

        $products = Product::where('type_id', $type->id);

        $this->assertEquals($type_products->count(), $products->count());
    }

    /** @test */
    public function a_request_stores_a_product()
    {
        $product = factory(Product::class)->make();

        $productName = $product->name;

        $response = $this->json(
            'POST',
            'product/store',
            [
                'code' => $product->code,
                'name' => $product->name,
                'description' => $product->description,
                'brand_id' => $product->brand_id,
                'type_id' => $product->type_id
            ]
        );

        $type = $product->type;
        $brand = $product->brand;

        unset($product->img);

        $product = $product->attributesToArray();

        $response
            ->assertStatus(201)
            ->assertJson($product);

        $this->assertDatabaseHas('products', [
            'name' => $productName,
        ]);

        $brands = $type->brands()->getResults();

        $this->assertTrue($brands->contains('id', $brand->id));
    }

    /** @test */
    public function a_request_stores_two_products_same_type_different_brand()
    {
        $product = factory(Product::class)->make();
        $product2 = factory(Product::class)->make();

        $response = $this->json(
            'POST',
            'product/store',
            [
                'code' => $product->code,
                'name' => $product->name,
                'description' => $product->description,
                'brand_id' => $product->brand_id,
                'type_id' => $product->type_id
            ]
        );

        $response
            ->assertStatus(201);

        $response2 = $this->json(
            'POST',
            'product/store',
            [
                'code' => $product2->code,
                'name' => $product2->name,
                'description' => $product2->description,
                'brand_id' => $product2->brand_id,
                'type_id' => $product->type_id
            ]
        );
        $response2
            ->assertStatus(201);

        $type = $product->type;
        $brand = $product->brand;

        $brand2 = $product2->brand;

        $brands = $type->brands()->getResults();

        $this->assertTrue($brands->contains('id', $brand->id));
        $this->assertTrue($brands->contains('id', $brand2->id));
    }

    /** @test */
    public function a_request_stores_two_products_same_brand_same_type()
    {
        $product = factory(Product::class)->make();
        $product2 = factory(Product::class)->make();

        $response = $this->json(
            'POST',
            'product/store',
            [
                'code' => $product->code,
                'name' => $product->name,
                'description' => $product->description,
                'brand_id' => $product->brand_id,
                'type_id' => $product->type_id
            ]
        );

        $response
            ->assertStatus(201);

        $response2 = $this->json(
            'POST',
            'product/store',
            [
                'code' => $product2->code,
                'name' => $product2->name,
                'description' => $product2->description,
                'brand_id' => $product->brand_id,
                'type_id' => $product->type_id
            ]
        );
        $response2
            ->assertStatus(201);

        $type = $product->type;
        $brand = $product->brand;

        $this->assertEquals(1, $type->brands()->count());
    }

    /** @test */
    public function a_request_gets_Product_index()
    {
        factory(Product::class, 25)->create();

        $producstBase = Product::all();

        $response = $this->json(
            'GET',
            'product/index'
        );

        $producstBase = $producstBase->toArray();

        $response
            ->assertStatus(200)
            ->assertJson($producstBase);
    }

    /** @test */
    public function a_request_gets_a_specific_Product()
    {
        $product = factory(Product::class)->create();

        $response = $this->json(
            'POST',
            'product/show',
            [
                'id' => $product->id,
            ]
        );

        $product = $product->attributesToArray();

        $response
            ->assertStatus(200)
            ->assertJson($product);
    }

    /** @test */
    public function a_request_deletes_a_specific_Product()
    {
        $product = factory(Product::class)->create();

        $productId = $product->id;

        $response = $this->json(
            'POST',
            'product/destroy',
            [
                'id' => $product->id,
            ]
        );

        $product = $product->attributesToArray();

        $response
            ->assertStatus(200)
            ->assertJson($product);

        $this->assertDeleted('products', [
            'id' => $productId
        ]);
    }

    /** @test */
    public function a_route_product_returns_view()
    {
        $response = $this->get('/product');

        $response
            ->assertStatus(200)
            ->assertViewIs('admin.product');
    }
}
