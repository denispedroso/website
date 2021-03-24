<?php

namespace Tests\Feature;

use App\Brand;
use App\Product;
use App\Type;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TypeTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function create_a_type_and_see_it_in_the_db()
    {
        $type = factory(Type::class)->create();

        $this->assertDatabaseHas('types', [
            'id' => $type->id
        ]);
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
    public function a_request_stores_a_type()
    {
        $type = factory(Type::class)->make();

        $typeName = $type->name;

        $response = $this->json(
            'POST',
            'type/store',
            [
                'name' => $type->name,
            ]
        );

        $type = $type->attributesToArray();

        $response
            ->assertStatus(201)
            ->assertJson($type);

        $this->assertDatabaseHas('types', [
            'name' => $typeName,
        ]);
    }


    /** @test */
    public function a_request_gets_Type_index()
    {
        factory(Type::class, 25)->create();

        $typeBase = Type::all();

        $response = $this->json(
            'GET',
            'type/index'
        );

        $typeBase = $typeBase->toArray();

        $response
            ->assertStatus(200)
            ->assertJson($typeBase);
    }

    /** @test */
    public function a_request_gets_a_specific_Type()
    {
        $type = factory(Type::class)->create();

        $response = $this->json(
            'POST',
            'type/show',
            [
                'id' => $type->id,
            ]
        );

        $type = $type->attributesToArray();

        $response
            ->assertStatus(200)
            ->assertJson($type);
    }

    /** @test */
    public function a_request_deletes_a_specific_Type()
    {
        $type = factory(Type::class)->create();

        $typeId = $type->id;

        $response = $this->json(
            'POST',
            'type/destroy',
            [
                'id' => $type->id,
            ]
        );

        $type = $type->attributesToArray();

        $response
            ->assertStatus(200)
            ->assertJson($type);

        $this->assertDeleted('types', [
            'id' => $typeId
        ]);
    }

    /** @test */
    public function a_route_product_returns_view()
    {
        $response = $this->get('/type');

        $response
            ->assertStatus(200)
            ->assertViewIs('admin.type');
    }
}
