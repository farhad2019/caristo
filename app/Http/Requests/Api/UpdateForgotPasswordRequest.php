<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseAPIRequest;

/**
 * @property mixed verification_code
 * @property mixed password
 * @property mixed email
 */
class UpdateForgotPasswordRequest extends BaseAPIRequest
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
    public function rules()
    {
        return [
            'verification_code'     => 'required',
            'email'                 => 'required',
            'password'              => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ];
    }
}