<?php

namespace App\Repositories\Admin;

use App\Models\CarType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CarTypeRepository
 * @package App\Repositories\Admin
 * @version October 8, 2018, 5:58 am UTC
 *
 * @method CarType findWithoutFail($id, $columns = ['*'])
 * @method CarType find($id, $columns = ['*'])
 * @method CarType first($columns = ['*'])
*/
class CarTypeRepository extends BaseRepository
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
        return CarType::class;
    }
}
