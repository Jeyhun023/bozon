<?php


namespace App\Repositories\V1\Contracts;


interface CityRepositoryInterface extends CrudInterface
{
    public function getAllCities();
    public function FilterCitiesForAdmin();
}
