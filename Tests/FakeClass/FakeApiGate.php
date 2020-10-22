<?php

namespace Modules\Food\Tests\FakeClass;

class FakeApiGate
{
    public static function findNothing($unused_search)
    {
        unset($unused_search);
        return collect([]);
    }

    public static function findSomething($unused_search)
    {
        unset($unused_search);
        return collect([
            [
              '_id' => 123456789,
              'product_name' => 'Salmiakki',
              'categories' => '	Naposteltavat, Pastilli, Salmiakki',
              'image_url' => 'http://somesite.somedomain/img1.jpg',
              'optional' => 'Salty liquorice, salmiak liquorice or salmiac liquorice,
                             is a variety of liquorice flavoured
                             with the ingredient "salmiak salt" (sal ammoniac; ammonium chloride),
                             and is a common confection found in the Nordic countries,
                             Benelux, and northern Germany.'
            ],
            [
              '_id' => 987654321,
              'product_name' => 'Bison Grass Vodka',
              'categories' => 'Napoje, Napoje alkoholowe, en:Hard liquors, en:Eaux de vie, en:Vodka',
              'image_url' => 'http://somesite.somedomain/img2.jpg',
              'optional' => 'Żubrówka Bison Grass Vodka is a flavored Polish vodka liqueur,
                             which contains a bison grass blade (Hierochloe odorata) in every bottle.'
            ],
        ]);
    }

    /**
     * Generate set of goods with one item has all fields and ten with one no fill field.
     * For one item for each field no set
     * and one item for each field is empty
     * @param $unused_search
     * @return \Illuminate\Support\Collection
     */
    public static function findSomethingBroken($unused_search)
    {
        unset($unused_search);
        $items = [];
        // Valid item with full set of fields
        $item =  [
              '_id' => 1029384756,
              'product_name' => 'Meatballs',
              'categories' => 'Canned foods, Meals, Microwave meals',
              'image_url' => 'http://somesite.somedomain/img3.jpg',
              'optional' => 'Frikadelle are flat, pan-fried meatballs of minced meat,
                             often likened to the Danish version of meatballs.
                             The origin of the dish is unknown.
                             The term "frikadelle" is German but the dish is associated with,
                             not only German, but also Danish, Scandinavian and Polish cuisines.'
            ];
        $items[] = $item;

        // Generate set of goods each with one missed field
        // After filtering must leave one with missed _optional_
        // Result: 1 valid and 4 broken
        foreach ($item as $key=>$value) {
            $items[] = array_diff($item, [$key=>$value]);
        }

        // Generate set of goods each with one field with empty value
        // After filtering must leave one with missed _optional_
        // Result: 1 valid and 4 broken
        foreach ($item as $key=>$value) {
            $_item = $item;
            $_item[$key] = '';
            $items[] = $_item;
        }

        return collect($items);
    }

    public function findWithException($message)
    {
        throw new \Exception($message);
    }
}
