<?php

namespace App\Repositories\Admin;

use App\Models\CarAttribute;
use App\Models\CarAttributeTranslation;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CarAttributeTranslationRepository
 * @package App\Repositories\Admin
 * @version October 8, 2018, 5:01 am UTC
 *
 * @method CarAttributeTranslation findWithoutFail($id, $columns = ['*'])
 * @method CarAttributeTranslation find($id, $columns = ['*'])
 * @method CarAttributeTranslation first($columns = ['*'])
 */
class CarAttributeTranslationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CarAttributeTranslation::class;
    }

    public function saveRecord($request)
    {
        $input = $request->all();
        $carAttribute = $this->create($input);
        return $carAttribute;
    }
}
