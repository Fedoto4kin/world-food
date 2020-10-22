<?php

namespace Tests\Food\Tests\Unit;

use Modules\Food\Tests\FakeClass\FakeApiGate;
use Modules\Food\Services\FoodProc;
use PHPUnit\Framework\TestCase;

class FoodProcTest extends TestCase
{
    public function testFindNothing()
    {
        $food = new FoodProc([FakeApiGate::class, 'findNothing']);
        $message = $food->proc('Something-no-mater');

        $this->assertEquals(0, $food->count());
        $this->assertEquals([], $food->all());
        $this->assertEquals('Nothing Found. Please change your search', $message);
    }

    public function testFindSomething()
    {
        $food = new FoodProc([FakeApiGate::class, 'findSomething']);
        $message = $food->proc('Something-no-mater');
        $this->assertEquals(2, $food->count());
        $this->assertEquals(1, count($food->forPage(1, 1)));
        $this->assertEquals('Found 2', $message);
    }

    public function testFindSomethingAndFilterBroken()
    {
        $food = new FoodProc([FakeApiGate::class, 'findSomethingBroken']);
        $message = $food->proc('Something-no-mater');
        $this->assertEquals(3, $food->count());
        $this->assertEquals(1, count($food->forPage(1, 1)));
        $this->assertEquals('Found 3', $message);
    }

    public function testExceptionRaise()
    {
        $exception_mess = 'Some Exception: something wrong';
        $food = new FoodProc([FakeApiGate::class, 'findWithException']);
        $message = $food->proc($exception_mess);
        $this->assertEquals(0, $food->count());
        $this->assertEquals([], $food->all());
        $this->assertEquals($exception_mess, $message);
    }
}
