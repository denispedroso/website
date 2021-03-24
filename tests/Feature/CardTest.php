<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Card;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CardTest extends TestCase
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
    public function testCardsModelandFactoryWorks()
    {
        $this->item = factory(\App\Card::class)->create();

        $this->assertDatabaseHas('cards', [
            'id' => $this->item->id
        ]);
    }

    /** @test */
    public function test_a_card_can_be_deleted()
    {
        $this->item = factory(\App\Card::class)->create();

        $this->assertDatabaseHas('cards', [
            'id' => $this->item->id
        ]);

        $card = Card::find($this->item->id);

        $card->delete();

        $this->assertDeleted('cards', [
            'id' => $this->item->id
        ]);
    }

    /** @test */
    public function test_(Type $var = null)
    {
        // todo Continuar teste daqui ...
    }
}
