<?php

namespace Tests\Unit;

use App\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * DeleteProductTest
 * @group group
 */
class DeleteProductTest extends TestCase
{

    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function test_product_deletes_brand_attached_function()
    {
        $product = factory(Product::class)->create();

        $response = $this->json(
            'POST',
            'product/destroy',
            [
                'id' => $product->id,
            ]
        );

        $response
            ->assertStatus(200);

        $brands = $product->type->brands()->getResults();

        $this->assertEquals(0, $brands->count());
    }


    /** @test */
    public function test_deletes_product_without_detach_brand_function()
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

        $response->assertStatus(201);
        $data = $response->json();
        $data = (object) $data;

        $product->id = $data->id;

        $response = $this->json(
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

        $response->assertStatus(201);

        $response = $this->json(
            'POST',
            'product/destroy',
            [
                'id' => $product->id,
            ]
        );

        $response
            ->assertStatus(200);

        $brands = $product->type->brands()->getResults();

        $this->assertEquals(1, $brands->count());
    }
}
