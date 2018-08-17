<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use InfyOm\Generator\Request\APIRequest;
use InfyOm\Generator\Utils\ResponseUtil;
use Response;

class BaseAPIRequest extends APIRequest
{
    protected function failedValidation(Validator $validator)
    {
        $excep = new ValidationException($validator);
        $excep->errorBag($this->errorBag)->redirectTo($this->getRedirectUrl());
        $excep->status = 200;
        $excep->response = Response::json(ResponseUtil::makeError("Validation Error", ['errors' => $excep->errors()]), 200);
        throw $excep;
    }

}