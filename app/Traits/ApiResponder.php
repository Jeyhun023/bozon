<?php


namespace App\Traits;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

trait ApiResponder
{
    protected $status = JsonResponse::HTTP_OK;
    protected $message = null;
    protected $data = [];

    /**
     * @param $data
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data, $code): JsonResponse
    {
        return response()->json($data, $code);
    }

    /**
     * @param $message
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message, $code): JsonResponse
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    /**
     *  Return result from repository method
     * @return array
     */
    protected function returnData(): array
    {
        return ['data' => $this->data,'message' => $this->message,'code' => $this->status];
    }

    protected function sendResponse(array $response): JsonResponse
    {
        return $response['code'] == JsonResponse::HTTP_OK || $response['code'] == JsonResponse::HTTP_CREATED ?
            $this->successResponse(['data' => $response['data'],'message' => $response['message']],$response['code']) :
            $this->errorResponse($response['message'],$response['code']);
    }

    protected function sendResourceResponse(array $response,$resource, $collection = true)
    {
            return $response['code'] == JsonResponse::HTTP_OK || $response['code'] == JsonResponse::HTTP_CREATED ?
                 $this->getResponseData($response,$resource,$collection):
                 $this->errorResponse($response['message'],$response['code']);
    }

    private function setResourceCollection($data,$resource,$collection){
        return $collection ? $resource::collection($data) : new $resource($data);
    }

    private function getResponseData($response,$resource,$collection)
    {
        return isset($response['data']) && !is_null($response['data']) ?
            $this->setResourceCollection($response['data'],$resource,$collection)->additional(['code' => $response['code'], 'message' => $response['message']]) :
            $this->successResponse(['data' => $response['data'],'message' => $response['message']],$response['code']);
    }
}
