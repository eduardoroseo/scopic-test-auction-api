<?php


namespace App\Services;


use App\Models\Item;

class ItemService
{
    public function all()
    {
        return Item::paginate(10);
    }
}
