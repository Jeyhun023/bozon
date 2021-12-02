<?php


namespace App\Repositories\V1\Contracts;


interface FileRepositoryInterface
{
    public function uploadFile($type,$data);
}
