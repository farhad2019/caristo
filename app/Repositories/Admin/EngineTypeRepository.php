<?php

namespace App\Repositories\Admin;

use App\Models\EngineType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class EngineTypeRepository
 * @package App\Repositories\Admin
 * @version October 8, 2018, 5:59 am UTC
 *
 * @method EngineType findWithoutFail($id, $columns = ['*'])
 * @method EngineType find($id, $columns = ['*'])
 * @method EngineType first($columns = ['*'])
 */
class EngineTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EngineType::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->all();
        $engineType = $this->create($input);
        return $engineType;
    }
}
