<?php


namespace App\Repositories\V1\Contracts;


interface VacancyRepositoryInterface extends CrudInterface
{
    public function getAllActiveVacancies();

    public function show($slug);
}
