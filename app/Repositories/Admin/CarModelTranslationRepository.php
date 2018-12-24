<?php

namespace App\Repositories\Admin;

use App\Models\CarModel;
use App\Models\CarModelTranslation;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CarModelTranslationRepository
 * @package App\Repositories\Admin
 * @version October 6, 2018, 6:35 am UTC
 *
 * @method CarModelTranslation findWithoutFail($id, $columns = ['*'])
 * @method CarModelTranslation find($id, $columns = ['*'])
 * @method CarModelTranslation first($columns = ['*'])
 */
class CarModelTranslationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'brand_id',
        'year'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CarModelTranslation::class;
    }

    /**
     * @param $request
     * @param $carModel
     * @return mixed
     */
    public function updateRecord($request, $carModel)
    {

        $input = $request->only(['name']);
        foreach ($input['name'] as $key => $name) {
            if ($name != '') {
                $update_data = [];
                $update_data['car_model_id'] = $carModel->id;
                $update_data['locale'] = $key;
                $update_data['name'] = $name;
                $this->model->updateOrCreate(['car_model_id' => $carModel->id, 'locale' => $key], $update_data);
            }
        }
        return $carModel;
    }
}
