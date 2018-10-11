<?php

namespace App\Repositories\Admin;

use App\Models\AttributeOption;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CarAttributeRepository
 * @package App\Repositories\Admin
 * @version October 8, 2018, 5:01 am UTC
 *
 * @method AttributeOption findWithoutFail($id, $columns = ['*'])
 * @method AttributeOption find($id, $columns = ['*'])
 * @method AttributeOption first($columns = ['*'])
 */
class AttributeOptionRepository extends BaseRepository
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
        return AttributeOption::class;
    }

    /**
     * @param $request
     * @param $carAttribute
     * @return mixed
     */
    public function saveRecord($request, $carAttribute)
    {
        $input = $request->only('options');
        $input['options'] = array_values(array_filter($input['options']));

        if (!empty($input['options'])) {
            foreach ($input['options'] as $key => $item) {
                $data['option'] = $item;
                $data['attribute_id'] = $carAttribute->id;
                $this->create($data);
            }
        }
        return $carAttribute;
    }
}
