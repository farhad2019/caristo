<?php

namespace App\Repositories\Admin;

use App\Models\CarBrand;
use App\Models\CarBrandTranslation;
use App\Models\CarFeatureTranslation;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CarFeatureTranslationRepository
 * @package App\Repositories\Admin
 * @version October 5, 2018, 6:26 am UTC
 *
 * @method CarFeatureTranslation findWithoutFail($id, $columns = ['*'])
 * @method CarFeatureTranslation find($id, $columns = ['*'])
 * @method CarFeatureTranslation first($columns = ['*'])
 */
class CarFeatureTranslationRepository extends BaseRepository
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
        return CarFeatureTranslation::class;
    }

    /**
     * @param $request
     * @param $carFeature
     * @return mixed
     */
    public function updateRecord($request, $carFeature)
    {
        $input = $request->only(['name']);

        foreach ($input['name'] as $key => $name) {
            if ($name != '') {
                $update_data = [];
                $update_data['feature_id'] = $carFeature->id;
                $update_data['locale'] = $key;
                $update_data['name'] = $name;
                $this->model->updateOrCreate(['feature_id' => $carFeature->id, 'locale' => $key], $update_data);
            }
        }
        return $carFeature;
    }
}
