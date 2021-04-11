<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveAutoBidConfigRequest;
use App\Http\Response\ApiResponse;
use App\Services\AutoBidConfigService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AutoBidConfigController extends Controller
{
    /**
     * @var AutoBidConfigService
     */
    private $service;

    public function __construct(AutoBidConfigService $service)
    {
        $this->service = $service;
    }

    public function show(Request $request)
    {
        try {
            return ApiResponse::success($this->service->getByUser($request->user()));
        } catch (ModelNotFoundException $e) {
            return ApiResponse::success(null, 204);
        }
    }

    public function save(SaveAutoBidConfigRequest $request)
    {
        $autoBidConfig = $this->service->save($request->user(), $request->validated());

        return ApiResponse::success($autoBidConfig);
    }

    public function disable(Request $request)
    {
        $this->service->delete($request->user());

        return ApiResponse::success(null, 204);
    }
}
