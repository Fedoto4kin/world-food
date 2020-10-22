<?php


namespace Modules\Food\Contracts;

interface FoodProcInterface
{
    public function all();

    public function proc(string $string): string;

    public function count(): int;

    public function forPage(int $page, int $per_page);
}
