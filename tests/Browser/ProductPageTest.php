<?php

namespace Tests\Browser;

use App\Product;
use App\Type;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProductPageTest extends DuskTestCase
{

    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_route_to_product()
    {
        $user = factory(User::class)->create([
            'email' => 'taylor@laravel.com',
        ]);

        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit('/product')
                ->assertPathIs('/product');
        });
    }

    /** @test */
    public function test_product_form_works()
    {
        $user = factory(User::class)->create([
            'email' => 'taylor@laravel.com',
        ]);

        $product = factory(\App\Product::class)->make();

        factory(Product::class, 5)->create();
        factory(Type::class, 5)->create();

        $this->browse(function (Browser $browser) use ($product) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit('/product')
                ->type('name', $product->name)
                ->type('code', $product->code)
                ->type('description', $product->description)
                ->press('save')
                ->whenAvailable('.modal', function ($modal) {
                    $modal->assertSee('Sucesso')
                        ->press('Fechar');
                });
        });
    }

    /** @test */
    public function test_product_form_button_resets_fields()
    {
        $user = factory(User::class)->create([
            'email' => 'taylor@laravel.com',
        ]);

        $product = factory(\App\Product::class)->make();

        $this->browse(function (Browser $browser) use ($product) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit('/product')
                ->type('name', $product->name)
                ->type('code', $product->code)
                ->type('description', $product->description)
                ->press('rreset')
                ->assertInputValue('name', '');
        });
    }

    /** @test */
    public function test_product_form_saves()
    {
        $user = factory(User::class)->create([
            'email' => 'taylor@laravel.com',
        ]);

        $product = factory(Product::class)->make();

        $this->browse(function (Browser $browser) use ($product) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit('/product')
                ->type('name', $product->name)
                ->type('code', $product->code)
                ->type('description', $product->description)
                ->press('save')
                ->whenAvailable('.modal', function ($modal) {
                    $modal->assertSee('Sucesso')
                        ->press('Fechar');
                });
        });

        $this->assertDatabaseHas('products', [
            'name' => $product->name,
        ]);
    }

    /** @test */
    public function test_product_form_deletes()
    {
        $user = factory(User::class)->create([
            'email' => 'taylor@laravel.com',
        ]);

        $product = factory(Product::class)->create();

        $this->browse(function (Browser $browser) use ($product) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit('/product')
                ->fillHidden('id', $product->id)
                ->press('excluir')
                ->whenAvailable('.modal', function ($modal) {
                    $modal->assertSee('Sucesso')
                        ->press('Fechar');
                });
        });

        $this->assertDeleted('products', [
            'id' => $product->id
        ]);
    }

    /** @test */
    public function test_product_form_field_type()
    {
        $user = factory(User::class)->create([
            'email' => 'taylor@laravel.com',
        ]);

        $types = factory(Type::class, 5)->create();
        $types = $types->toArray();

        $this->browse(function (Browser $browser) use ($types) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit('/product')
                ->pause(3000)
                ->assertSeeIn('@type_id', $types[0]['name']);
        });
    }
}
