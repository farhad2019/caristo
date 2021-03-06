<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseFormRequest;
use App\Models\MyCar;

class UpdateMyCarRequest extends BaseFormRequest
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
        $validationMessages = [];
        $validationMessages = array_merge($validationMessages, [
            'amount.required' => 'The amount field is required.',
            'media.required'  => 'The media is required.',
            'media.*.mimes'   => 'The media must be a file of type: jpg, jpeg, png.',
            'media.*'         => 'The media may not be greater than 500 kilobytes.',
            'price.required'  => 'The price must be filled.',
            'price.*'         => 'The all price must be filled.',
            'name.required'   => 'The name field is required.',
            'chassis.required'     => 'The chassis field is required.',
            'year.required'   => 'The year field is required.',
            'average_mkp.required' => 'The average MKP field is required.',
            'kilometer.required'   => 'The mileage field is required.',

        ]);

        return $validationMessages;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $validationArray = [
//            'category_id' => 'required',
            'amount'      => 'required',
            'name'        => 'required',
            'chassis'     => 'required',
        ];


        if ($this->input('category_id') == MyCar::LIMITED_EDITION) {
            $validationArray = array_merge($validationArray, [
                'is_featured'        => 'check_featured',
                'length'             => 'required',
                'width'              => 'required',
                'height'             => 'required',
                'weight_dist'        => 'required',
                'trunk'              => 'required',
                'weight'             => 'required',
                'seats'              => 'required',
                'drive_train'        => 'required',
                'displacement'       => 'required',
                'cylinders'          => 'required',
                'max_speed'          => 'required',
                'acceleration'       => 'required',
                'hp_rpm'             => 'required',
                'torque'             => 'required',
                'gearbox'            => 'required',
                'brakes'             => 'required',
                'suspension'         => 'required',
                'front_tyre'         => 'required',
                'back_tyre'          => 'required',
                'consumption'        => 'required',
                'emission'           => 'required',
                'warranty'           => 'required',
                'maintenance'        => 'required',
                'to'                 => 'required|greater_than_field:from',
                'depreciation_trend' => 'required',
                'price'              => 'required',
                'price.*'            => 'numeric',
                'media'              => 'required',
                'media.*'            => 'image|mimes:jpg,jpeg,png|max:500'
            ]);

        } elseif ($this->input('category_id') == MyCar::APPROVED_PRE_OWNED || $this->input('category_id') == MyCar::CLASSIC_CARS) {
            $validationArray = array_merge($validationArray, [
                'average_mkp' => 'required',
                'kilometer'   => 'required',
                'media'       => 'required',
                'is_featured' => 'check_featured',
                'media.*'     => 'image|mimes:jpg,jpeg,png|max:500',
                'attribute.*' => 'attr'
            ]);

        } else {
            $validationArray = array_merge($validationArray, [
                'year'        => 'required',
                'phone'       => 'phone',
                'media'       => 'required',
                'media.*'     => 'image|mimes:jpg,jpeg,png|max:500',
                'is_featured' => 'check_featured',
                'attribute.*' => 'attr'
            ]);

        }
        return $validationArray;
//        return MyCar::$update_rules;
    }
}
