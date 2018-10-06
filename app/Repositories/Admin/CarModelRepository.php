<?php

namespace App\Repositories\Admin;

use App\Models\CarModel;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CarModelRepository
 * @package App\Repositories\Admin
 * @version October 6, 2018, 6:35 am UTC
 *
 * @method CarModel findWithoutFail($id, $columns = ['*'])
 * @method CarModel find($id, $columns = ['*'])
 * @method CarModel first($columns = ['*'])
 */
class CarModelRepository extends BaseRepository
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
        return CarModel::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->all();
        $carModel = $this->create($input);
        return $carModel;
    }

    public function updateRecord($request, $carModel)
    {
        $input = $request->all();
        $carModel = $this->update($input, $carModel->id);
        return $carModel;
    }
}
