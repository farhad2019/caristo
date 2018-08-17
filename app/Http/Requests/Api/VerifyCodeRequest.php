<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseAPIRequest;


class VerifyCodeRequest extends BaseAPIRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'verification_code' => 'required'
        ];
    }
}
