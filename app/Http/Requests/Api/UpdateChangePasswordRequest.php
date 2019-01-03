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
            'old_password'          => 'required',
            'password'              => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
        ];
    }

}
