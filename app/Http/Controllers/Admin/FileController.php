<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\V1\FileRequest;
use App\Repositories\V1\Contracts\FileRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class FileController extends Controller
{
    use ApiResponder;
    /**
     * @var FileRepositoryInterface
     */
    private $fileRepository;

    public function __construct(FileRepositoryInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function uploadFile($type,FileRequest $request)
    {
        $result = $this->fileRepository->uploadFile($type,$request->all());
        return $this->sendResponse($result);
    }
}
