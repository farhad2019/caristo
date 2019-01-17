<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseAPIRequest;

class UpdateChangePasswordRequest extends BaseAPIRequest
{

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    /*public function messages()
    {
        return [
            'password.old_password' => 'The Password And The Old Password Must Be Different'
        ];
    }*/

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'old_password'          => 'required',
            'password'              => 'min:6|required_with:password_confirmation|same:password_confirmation|different:old_password',
            'password_confirmation' => 'min:6',
        ];
    }

}
