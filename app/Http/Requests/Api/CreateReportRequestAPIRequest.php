<?php

namespace App\Http\Requests\Api;

use App\Models\ReportRequest;
use App\Http\Requests\BaseAPIRequest;

class CreateReportRequestAPIRequest extends BaseAPIRequest
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
        return ReportRequest::$api_rules;
    }
}
