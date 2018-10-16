<?php

namespace App\Repositories\Admin;

use App\Models\CarBrand;
use App\Models\CarBrandTranslation;
use App\Models\CarFeatureTranslation;
use App\Models\CarTypeTranslation;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CarTypeTranslationRepository
 * @package App\Repositories\Admin
 * @version October 5, 2018, 6:26 am UTC
 *
 * @method CarTypeTranslation findWithoutFail($id, $columns = ['*'])
 * @method CarTypeTranslation find($id, $columns = ['*'])
 * @method CarTypeTranslation first($columns = ['*'])
 */
class CarTypeTranslationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'created_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CarTypeTranslation::class;
    }

    /**
     * @param $request
     * @param $carType
     * @return mixed
     */
    public function updateRecord($request, $carType)
    {
        $input = $request->only(['name']);

        foreach ($input['name'] as $key => $name) {
            if ($name != '') {
                $update_data = [];
                $update_data['car_type_id'] = $carType->id;
                $update_data['locale'] = $key;
                $update_data['name'] = $name;
                $this->model->updateOrCreate(['car_type_id' => $carType->id, 'locale' => $key], $update_data);
            }
        }
        return $carType;
    }
}
