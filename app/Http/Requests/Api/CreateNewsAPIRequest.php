<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseAPIRequest;
use App\Models\News;

class CreateNewsAPIRequest extends BaseAPIRequest
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
        return News::$api_rules;
    }
}
