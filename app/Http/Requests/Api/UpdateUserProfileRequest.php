<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseAPIRequest;

class UpdateUserProfileRequest extends BaseAPIRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
//            'email' => 'required'
//            'name'         => 'string',
//            'country_code' => 'string',
//            'phone'        => 'string',
//            'about'        => 'string',
            'image' => 'image',
        ];
    }

}
