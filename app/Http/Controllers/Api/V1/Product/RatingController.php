<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Product\RatingRequest;
use App\Http\Resources\RatingResource;
use App\Repositories\V1\Contracts\RatingRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    use ApiResponder;


    /**
     * @var RatingRepositoryInterface
     */
    private $ratingRepository;

    public function __construct(RatingRepositoryInterface  $ratingRepository)
    {
        $this->ratingRepository = $ratingRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->ratingRepository->index();
        return $this->sendResourceResponse($result,RatingResource::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RatingRequest $request)
    {
        $result = $this->ratingRepository->store($request->except('user_id','status'));
        return $this->sendResourceResponse($result,RatingResource::class,false);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
