<?php

namespace App\Http\Requests\Api;

use App\Models\Subscriber;
use App\Http\Requests\BaseAPIRequest;

class CreateSubscriberAPIRequest extends BaseAPIRequest
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

    public function messages()
    {
        return [
            'email.unique' => 'You have already been subscribed.'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Subscriber::$api_rules;
    }
}
