<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ColorResource;
use App\Repositories\V1\Contracts\ColorRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    use ApiResponder;

    /**
     * @var ColorRepositoryInterface
     */
    private $colorRepository;

    public function __construct(ColorRepositoryInterface  $colorRepository)
    {
        $this->colorRepository = $colorRepository;
    }

    public function index()
    {
        $result = $this->colorRepository->getAllColors();
        return  $this->sendResourceResponse($result,ColorResource::class);
    }
}
