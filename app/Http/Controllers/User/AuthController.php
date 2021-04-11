<?php


namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Response\ApiResponse;
use App\Services\User\LoginService;

class AuthController extends Controller
{
    /**
     * @var LoginService
     */
    private $service;

    public function __construct(LoginService $service)
    {
        $this->service = $service;
    }

    public function login(LoginRequest $request)
    {
        $token = $this->service->login($request->validated());

        return ApiResponse::success($token);
    }
}
