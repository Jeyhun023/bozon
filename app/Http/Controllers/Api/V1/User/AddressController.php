<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\AddressRequest;
use App\Http\Resources\AddressResource;
use App\Repositories\V1\Contracts\AddressRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    use ApiResponder;

    /**
     * @var AddressRepositoryInterface
     */
    private $addressRepository;

    /**
     * AddressController constructor.
     * @param AddressRepositoryInterface $addressRepository
     */
    public function __construct(AddressRepositoryInterface $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->addressRepository->index();
        return $this->sendResourceResponse($result,AddressResource::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddressRequest $request)
    {
        $result = $this->addressRepository->store($request->except('is_default','user_id'));
        return $this->sendResourceResponse($result,AddressResource::class,false);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddressRequest $request, $id)
    {
        $result = $this->addressRepository->update($id,$request->except('is_default','user_id'));
        return $this->sendResourceResponse($result,AddressResource::class,false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->addressRepository->destroy($id);
        return $this->sendResourceResponse($result,AddressResource::class,false);
    }

    public function setDefault(Request  $request)
    {
        $result = $this->addressRepository->setDefault($request->product_id);
        return $this->sendResourceResponse($result,AddressResource::class,false);
    }
}
