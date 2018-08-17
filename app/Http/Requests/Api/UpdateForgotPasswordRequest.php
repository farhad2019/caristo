<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseAPIRequest;

class UpdateForgotPasswordRequest extends BaseAPIRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'verification_code' => 'required',
            'email'             => 'required',
            'password'          => 'required'
        ];
    }

}
