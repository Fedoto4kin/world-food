<?php

namespace Tests\Feature\Modules\Food\Http\Controllers;

use Tests\TestCase;
use Modules\Food\Entities\Food;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker;

class StoreControllerTest extends TestCase
{
    use DatabaseTransactions;
    private const EX_ID = 1234567890;

    private static function genItem()
    {
        $faker = Faker\Factory::create();
        return [
              'ex_id' => self::EX_ID,
              'product_name' => $faker->word(),
              'categories' => implode(', ', $faker->words(5)),
              'image_url' => $faker->imageUrl(400, 300),
              'image_thumb_url' => $faker->imageUrl(40, 30)
            ];
    }

    private function makeActionSave()
    {
        $item = self::genItem();

        $response = $this->json('POST', '/', ['data' => $item]);
        $response->assertStatus(200)
                ->assertJson([
                'success' => true,
                 'message' => 'Item was saved'
                ]);

        return $item;
    }

    public function testValidate()
    {
        $response = $this->json('POST', '/', []);
        $response->assertStatus(422);
        $response->assertSee('The given data was invalid');
    }

    public function testItemSaveUpdate()
    {

        //Check no exists
        $this->assertNull(Food::whereExId(self::EX_ID)->first());

        // Create item
        $item = $this->makeActionSave();

        $this->assertEquals(1, Food::whereExId(1234567890)->count());
        $saved_item = Food::whereExId(self::EX_ID)->first();

        foreach ($item as $key=>$value) {
            $this->assertEquals($value, $saved_item->{$key});
        }

        // Update item
        $item = $this->makeActionSave();

        //Still only one record
        $this->assertEquals(1, Food::whereExId(1234567890)->count());
        $updated_item = Food::whereExId(self::EX_ID)->first();

        foreach ($item as $key=>$value) {
            $this->assertEquals($value, $updated_item->{$key});
        }
    }
}
