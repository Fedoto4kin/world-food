<?php

namespace Tests\Feature\Modules\Food\Http\Controllers;

use Tests\TestCase;
use Modules\Food\Tests\FakeClass\FakeApiGate;
use OpenFoodFacts\Laravel\Facades\OpenFoodFacts;

class SearchControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAccess()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Word\'s Food');
    }

    public function testSubmit()
    {
        OpenFoodFacts::shouldReceive('find')
            ->once()
            ->with('salmiakki')
            ->andReturn(
                FakeApiGate::findSomething('Something-no-mater')
            );

        $response = $this->get('/?search=salmiakki');
        $response->assertStatus(200);
        $response->assertSee('Found 2');

        $response->assertSee('123456789');
        $response->assertSee('Salmiakki');

        $response->assertSee('987654321');
        $response->assertSee('Bison Grass Vodka');
    }
}
