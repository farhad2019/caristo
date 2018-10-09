<?php

namespace App\Http\Requests\Api;

use App\Models\CarAttribute;
use App\Http\Requests\BaseAPIRequest;

class CreateCarAttributeAPIRequest extends BaseAPIRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
        return CarAttribute::$api_rules;
    }
}
