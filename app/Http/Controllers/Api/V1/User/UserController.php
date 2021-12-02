<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\UserPasswordUpdateRequest;
use App\Http\Requests\Api\V1\User\UserUpdateRequest;
use App\Repositories\V1\Contracts\UserRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    use ApiResponder;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return JsonResponse
     */
    public function getAuthenticatedUser(): JsonResponse
    {
        $result = $this->userRepository->getAuthenticatedUser();
        return $this->sendResponse($result);
    }

    /**
     * @param UserUpdateRequest $request
     * @return JsonResponse
     */
    public function update(UserUpdateRequest $request): JsonResponse
    {
        $result = $this->userRepository->update($request->except('password'));
        return $this->sendResponse($result);
    }

    public function updatePassword(UserPasswordUpdateRequest $request): JsonResponse
    {
        $result = $this->userRepository->update($request->only('password'));
        return $this->sendResponse($result);
    }
}
