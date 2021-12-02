<?php


namespace App\Repositories\V1\Contracts;


interface UserRepositoryInterface
{
    public function update(array $data): array;

    public function getAuthenticatedUser(): array;
}
