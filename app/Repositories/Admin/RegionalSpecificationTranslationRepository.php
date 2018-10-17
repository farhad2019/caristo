<?php

namespace App\Repositories\Admin;

use App\Models\RegionalSpecificationTranslation;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RegionalSpecificationTranslationRepository
 * @package App\Repositories\Admin
 * @version October 5, 2018, 6:26 am UTC
 *
 * @method RegionalSpecificationTranslation findWithoutFail($id, $columns = ['*'])
 * @method RegionalSpecificationTranslation find($id, $columns = ['*'])
 * @method RegionalSpecificationTranslation first($columns = ['*'])
 */
class RegionalSpecificationTranslationRepository extends BaseRepository
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
        return RegionalSpecificationTranslation::class;
    }

    /**
     * @param $request
     * @param $regionalSpecification
     * @return mixed
     */
    public function updateRecord($request, $regionalSpecification)
    {
        $input = $request->only(['name']);

        foreach ($input['name'] as $key => $name) {
            if ($name != '') {
                $update_data = [];
                $update_data['regional_specification_id'] = $regionalSpecification->id;
                $update_data['locale'] = $key;
                $update_data['name'] = $name;
                $this->model->updateOrCreate(['regional_specification_id' => $regionalSpecification->id, 'locale' => $key], $update_data);
            }
        }
        return $regionalSpecification;
    }
}
