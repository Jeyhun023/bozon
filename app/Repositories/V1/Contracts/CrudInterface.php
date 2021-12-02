<?php


namespace App\Repositories\V1\Contracts;


interface CrudInterface
{
    public function index();

    public function store(array $data);

    public function show(int $id);

    public function update(int $id, array $data);

    public function destroy(int $id);
}
