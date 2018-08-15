<?php

namespace App\Http\Requests\Api;

use App\Models\SocialAccount;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use InfyOm\Generator\Request\APIRequest;
use InfyOm\Generator\Utils\ResponseUtil;
use \Response;

class SocialLoginAPIRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this registration.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return SocialAccount::$rules;
    }

    protected function failedValidation(Validator $validator)
    {
        $excep = new ValidationException($validator);
        $excep->errorBag($this->errorBag)->redirectTo($this->getRedirectUrl());
        $excep->status = 200;
        $excep->response = Response::json(ResponseUtil::makeError("Validation Error", $excep->errors()));
        throw $excep;
    }
}
