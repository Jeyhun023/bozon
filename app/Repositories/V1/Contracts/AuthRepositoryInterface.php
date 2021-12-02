<?php


namespace App\Repositories\V1\Contracts;


interface AuthRepositoryInterface extends CrudInterface
{
    public function login(array $credentials): array;

    public function register(array $data): array;

    public function sendCode(string $phone_number,int $tokenType): array;

    public function checkVerificationCode(string $phone_number, string $code,int $tokenType): array;

    public function resetPassword(array $data): array;
}
