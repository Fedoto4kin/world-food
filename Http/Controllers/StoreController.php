<?php

namespace Modules\Food\Http\Controllers;

use Modules\Food\Entities\Food;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class StoreController extends Controller
{

    /**
     * Store a newly created resource in storage or update existing
     * @param Request $request
     * @return json
     */
    public function store(Request $request)
    {
        $request->validate([
            'data.ex_id' => 'required|integer',
            'data.product_name' => 'required',
            'data.categories' => 'required',
            'data.image_url' => 'required|active_url',
            'data.image_thumb_url' => 'required|active_url',

        ]);

        $data = $request->all();

        $food = Food::firstOrNew(
            ['ex_id' => $data['data']['ex_id']]
        );
        $food->product_name = $data['data']['product_name'];
        $food->categories = $data['data']['categories'];
        $food->image_url = $data['data']['image_url'];
        $food->image_thumb_url = $data['data']['image_thumb_url'];
        $food->save();

        return response()->json(['success'=> true, 'message' => 'Item was saved']);
    }
}
