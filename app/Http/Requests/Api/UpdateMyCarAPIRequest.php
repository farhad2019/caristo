<?php

namespace App\Http\Requests\Api;

use App\Models\MyCar;
use App\Http\Requests\BaseAPIRequest;

class UpdateMyCarAPIRequest extends BaseAPIRequest
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
        return MyCar::$api_updating_rules;
    }
}
