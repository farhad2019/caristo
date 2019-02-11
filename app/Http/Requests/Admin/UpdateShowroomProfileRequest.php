<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseFormRequest;
use App\Models\User;

class UpdateShowroomProfileRequest extends BaseFormRequest
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
    public function messages()
    {
        return [
            'showroom_media.dimensions' => 'Media shouldn\'t exceed dimension of 192 x 192'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return User::$updateShowroomProfileRules;
    }
}
