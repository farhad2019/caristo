<?php

namespace App\Repositories\Admin;

use App\Models\AttributeOptionTranslation;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AttributeOptionTranslationRepository
 * @package App\Repositories\Admin
 * @version October 8, 2018, 5:01 am UTC
 *
 * @method AttributeOptionTranslation findWithoutFail($id, $columns = ['*'])
 * @method AttributeOptionTranslation find($id, $columns = ['*'])
 * @method AttributeOptionTranslation first($columns = ['*'])
 */
class AttributeOptionTranslationRepository extends BaseRepository
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
        return AttributeOptionTranslation::class;
    }

    public function saveRecord($request)
    {
        $input = $request->all();
        $carAttribute = $this->create($input);
        return $carAttribute;
    }
}
