<?php

namespace App\Http\Requests\Api;

use App\Helpers\RESTAPIHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateChangePasswordRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    protected function failedValidation(Validator $validator)
    {
        $response = RESTAPIHelper::response([], 404, $validator->errors()->first());
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }


    public function rules()
    {
        return [
            'password'             => 'required',
            'new_password'          => 'required'
        ];
    }

}
