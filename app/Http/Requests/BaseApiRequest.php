<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use App\Utils\AppConstant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


abstract class BaseApiRequest extends FormRequest
{
    use ApiResponse;

    /**
     * Parent validation resolving
     */
    public function validateResolved()
    {
        parent::validateResolved();
    }

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
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $this->setMeta('status', AppConstant::STATUS_FAIL);
        $this->setMeta('message', $validator->messages()->first());
        throw new HttpResponseException(response()->json($this->setResponse(), AppConstant::UNPROCESSABLE_REQUEST));
    }
}
