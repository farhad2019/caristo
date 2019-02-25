<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseFormRequest;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
            'banner_media.required' => 'The banner image field is required.',
            'banner_media.*.image'  => 'Please select valid banner image file.',
            'banner_media.*.mimes'  => 'The banner image must be a file of type: jpg, jpeg, png.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Category::$rules;
    }
}
