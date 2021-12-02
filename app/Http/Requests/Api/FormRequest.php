<?php


namespace App\Http\Requests\Api;

use App\Traits\ApiResponder;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;


abstract class FormRequest extends LaravelFormRequest
{
    use ApiResponder;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize();


    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            $this->errorResponse($errors,JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

    /**
     *  Handle a failed authorization attempt.
     */
    protected function failedAuthorization()
    {
        throw new HttpResponseException(
            $this->errorResponse(['data' => null,'message' => trans('auth.unauthorized')],JsonResponse::HTTP_FORBIDDEN)
        );
    }
}
