<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\CheckVerificationRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Http\Requests\Api\V1\Auth\VerificationPhoneRequest;
use App\Repositories\V1\Contracts\AuthRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    use ApiResponder;
    /**
     * @var AuthRepositoryInterface
     */
    private $authRepository;

    /**
     * RegisterController constructor.
     * @param AuthRepositoryInterface $authRepository
     */
    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     *  Send verification code to user phone number
     *
     * @param VerificationPhoneRequest $request
     * @return JsonResponse
     */
    public function sendCode(VerificationPhoneRequest $request): JsonResponse
    {
        $result = $this->authRepository->sendCode($request->phone,$request->token_type);
        return $this->sendResponse($result);
    }

    /**
     * @param CheckVerificationRequest $request
     * @return JsonResponse
     */
    public function checkVerificationCode(CheckVerificationRequest $request): JsonResponse
    {
        $result = $this->authRepository->checkVerificationCode($request->phone,$request->code,$request->token_type);
        return $this->sendResponse($result);
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authRepository->register($request->all());
        return $this->sendResponse($result);
    }
}
