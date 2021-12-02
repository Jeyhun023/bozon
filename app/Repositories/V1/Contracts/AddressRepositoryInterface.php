<?php


namespace App\Repositories\V1\Contracts;


interface AddressRepositoryInterface extends CrudInterface
{
    public function setDefault($id);
}
