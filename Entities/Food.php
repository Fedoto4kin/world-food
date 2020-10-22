<?php

namespace Modules\Food\Entities;

use Database\Factories\FoodFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';
    protected $fillable = ['ex_id', 'product_name', 'categories', 'image_url', 'image_thumb_url'];
}
