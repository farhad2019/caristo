<?php

namespace App\Http\Requests\Api;

use App\Models\EngineType;
use App\Http\Requests\BaseAPIRequest;

class CreateEngineTypeAPIRequest extends BaseAPIRequest
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
        return EngineType::$api_rules;
    }
}
