<?php

namespace App\Http\Controllers\Api\V1\Other;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Other\ContactRequest;
use App\Repositories\V1\Contracts\ContactFormRepositoryInterface;
use App\Traits\ApiResponder;

class ContactController extends Controller
{
    use ApiResponder;

    /**
     * @var ContactFormRepositoryInterface
     */
    private $contactFormRepository;

    public function __construct(ContactFormRepositoryInterface $contactFormRepository)
    {
        $this->contactFormRepository = $contactFormRepository;
    }

    public function store(ContactRequest $request)
    {
        $result = $this->contactFormRepository->store($request->all());
        return $this->sendResponse($result);
    }
}
