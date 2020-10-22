<?php


namespace Modules\Food\Services;

use Illuminate\Support\Collection as Collection;
use Modules\Food\Contracts\FoodProcInterface;

class FoodProc implements FoodProcInterface
{
    //TODO: Load from module config
    private const MUST_HAVE_FIELDS =  array(
        '_id',
        'image_url',
        'product_name',
        'categories'
    );

    private Collection $data;
    private $getFromGateway;

    private static function find($getFromGateway, string $search)
    {
        return $getFromGateway($search);
    }

    public function __construct($getFromGateway=[])
    {
        $this->data = collect();
        $this->getFromGateway = $getFromGateway;
    }

    public function all()
    {
        return $this->data->all();
    }

    public function count(): int
    {
        return $this->data->count();
    }

    public function forPage($page, $per_page)
    {
        return $this->data->forPage($page, $per_page);
    }

    /**
     * Remove items from $this->data which do not contain MUST_HAVE_FIELDS fields
     */
    private function filter()
    {
        $need_keys = self::MUST_HAVE_FIELDS;
        $this->data = $this->data->filter(function ($item) use ($need_keys) {
            $item = array_filter($item, function ($value) {
                return !empty($value);
            });
            if (!array_diff_key(array_flip($need_keys), $item)) {
                return $item;
            }
        });
    }

    public function proc(string $search): string
    {
        try {
            $this->data = self::find($this->getFromGateway, $search);
            $this->filter();
            if ($this->data->count()) {
                $message = 'Found ' . $this->data->count();
            } else {
                $message = 'Nothing Found. Please change your search';
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return $message;
    }
}
