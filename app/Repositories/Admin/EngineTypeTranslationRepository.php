<?php

namespace App\Repositories\Admin;

use App\Models\EngineTypeTranslation;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class EngineTypeTranslationRepository
 * @package App\Repositories\Admin
 * @version October 5, 2018, 6:26 am UTC
 *
 * @method EngineTypeTranslation findWithoutFail($id, $columns = ['*'])
 * @method EngineTypeTranslation find($id, $columns = ['*'])
 * @method EngineTypeTranslation first($columns = ['*'])
 */
class EngineTypeTranslationRepository extends BaseRepository
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
        return EngineTypeTranslation::class;
    }

    /**
     * @param $request
     * @param $engineType
     * @return mixed
     */
    public function updateRecord($request, $engineType)
    {
        $input = $request->only(['name']);

        foreach ($input['name'] as $key => $name) {
            if ($name != '') {
                $update_data = [];
                $update_data['engine_type_id'] = $engineType->id;
                $update_data['locale'] = $key;
                $update_data['name'] = $name;
                $this->model->updateOrCreate(['engine_type_id' => $engineType->id, 'locale' => $key], $update_data);
            }
        }
        return $engineType;
    }
}
