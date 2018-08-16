<?php

namespace App\Http\Requests\Api;

use App\Helpers\RESTAPIHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use InfyOm\Generator\Utils\ResponseUtil;

class UpdateChangePasswordRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    /*protected function failedValidation(Validator $validator)
    {
//        $response = RESTAPIHelper::response([], 404, $validator->errors()->first());
        return \Response::json(ResponseUtil::makeError('Validation Error', ['error' => $validator->errors()->first()]), 404);
//        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }*/


    public function rules()
    {
        return [
            'old_password' => 'required',
            'new_password' => 'required'
        ];
    }

}
