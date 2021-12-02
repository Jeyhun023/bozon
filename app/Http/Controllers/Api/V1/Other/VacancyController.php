<?php

namespace App\Http\Controllers\Api\V1\Other;

use App\Http\Controllers\Controller;
use App\Http\Resources\VacancyResource;
use App\Repositories\V1\Contracts\VacancyRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    use ApiResponder;

    /**
     * @var VacancyRepositoryInterface
     */
    private VacancyRepositoryInterface $vacancyRepository;

    public function __construct(VacancyRepositoryInterface $vacancyRepository)
    {
        $this->vacancyRepository = $vacancyRepository;
    }

    public function index()
    {
        $result = $this->vacancyRepository->getAllActiveVacancies();
        return $this->sendResourceResponse($result,VacancyResource::class);
    }

    public function show($slug)
    {
        $result = $this->vacancyRepository->show($slug);
        return $this->sendResourceResponse($result,VacancyResource::class,false);
    }
}
