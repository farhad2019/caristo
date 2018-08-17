<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseAPIRequest;

class UpdateUserProfileRequest extends BaseAPIRequest
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
//            'email' => 'required'
        ];
    }

}
