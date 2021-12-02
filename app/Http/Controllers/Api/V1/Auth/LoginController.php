<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Repositories\V1\Contracts\AuthRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    use ApiResponder;

    /**
     * @var AuthRepositoryInterface
     */
    private $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
       $result = $this->authRepository->login($request->all());
       return $this->sendResponse($result);
    }

    public function resetPassword(LoginRequest $request): JsonResponse
    {
        $result = $this->authRepository->resetPassword($request->all());
        return $this->sendResponse($result);
    }
}
