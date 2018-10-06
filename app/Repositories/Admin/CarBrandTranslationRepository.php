<?php

namespace App\Repositories\Admin;

use App\Models\CarBrand;
use App\Models\CarBrandTranslation;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CarBrandTranslationRepository
 * @package App\Repositories\Admin
 * @version October 5, 2018, 6:26 am UTC
 *
 * @method CarBrandTranslation findWithoutFail($id, $columns = ['*'])
 * @method CarBrandTranslation find($id, $columns = ['*'])
 * @method CarBrandTranslation first($columns = ['*'])
 */
class CarBrandTranslationRepository extends BaseRepository
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
        return CarBrandTranslation::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->all();
        $carBrand = $this->create($input);
        return $carBrand;
    }

    /**
     * @param $request
     * @param $carBrand
     * @return mixed
     */
    public function updateRecord($request, $carBrand)
    {
        $input = $request->only(['name']);

        foreach ($input['name'] as $key => $name) {
            if ($name != '') {
                $update_data = [];
                $update_data['brand_id'] = $carBrand->id;
                $update_data['locale'] = $key;
                $update_data['name'] = $name;
                $this->model->updateOrCreate(['brand_id' => $carBrand->id, 'locale' => $key], $update_data);
            }
        }
        return $carBrand;
    }
}
