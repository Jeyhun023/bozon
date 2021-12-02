<?php

namespace App\Http\Controllers\Api\V1\Other;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Repositories\V1\Contracts\BlogRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    use ApiResponder;

    /**
     * @var BlogRepositoryInterface
     */
    private BlogRepositoryInterface $blogRepository;

    public function __construct(BlogRepositoryInterface $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    public function index()
    {
        $result = $this->blogRepository->getActiveBlogs();
        return $this->sendResourceResponse($result,BlogResource::class);
    }

    public function show($slug)
    {
        $result = $this->blogRepository->show($slug);
        return $this->sendResourceResponse($result,BlogResource::class,false);
    }
}
