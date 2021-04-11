<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoBidToItemRequest;
use App\Http\Requests\ItemListRequest;
use App\Http\Response\ApiResponse;
use App\Models\Item;
use App\Services\ItemService;

class ItemController extends Controller
{
    /**
     * @var ItemService
     */
    private $service;

    public function __construct(ItemService $service)
    {
        $this->service = $service;
    }

    public function index(ItemListRequest $request)
    {
        return ApiResponse::list($this->service->all($request->validated()));
    }

    public function doBid(Item $item, DoBidToItemRequest $request)
    {
        $updatedItem = $this->service->doBid($item, $request->user(), $request->validated());

        return ApiResponse::success($updatedItem);
    }
}
