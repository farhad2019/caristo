<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseAPIRequest;

class UpdateChangePasswordRequest extends BaseAPIRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'old_password' => 'required',
            'password'     => 'required|min:6|confirmed|different:old_password'
        ];
    }

}
