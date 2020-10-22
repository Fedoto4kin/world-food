<?php

namespace Modules\Food\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use OpenFoodFacts\Laravel\Facades\OpenFoodFacts;
use Modules\Food\Services\FoodProc;

class SearchController extends Controller
{
    protected object $food;

    public function __construct(FoodProc $food)
    {
        $this->food = new $food([OpenFoodFacts::class, 'find']);
    }

    /**
     * @param Request $request
     * @return Renderable
     */
    public function search(Request $request)
    {
        \Session::flash('alert', null);
        $search = $request->input('search');
        $page =  (int) $request->input('page', 1);
        $per_page = 20;

        if ($search) {
            $message = $this->food->proc($search);
            \Session::flash('alert', $message);
        }


        $pagination = new LengthAwarePaginator(
            $this->food->forPage($page, $per_page),
            $this->food->count(),
            $per_page,
            $page
        );
        $pagination->appends(['search' => $search]);

        return view('food::index')
                    ->with(
                        [
                        'search' => $search,
                        'data' => $pagination->items(),
                        'pagination' => $pagination]
                    );
    }
}
