<?php

namespace App\Http\Controllers;

use App\Http\Response\ApiResponse;
use App\Services\ItemService;
use Illuminate\Http\Request;

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

    public function index()
    {
        return ApiResponse::list($this->service->all());
    }
}
