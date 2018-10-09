<?php

namespace App\Repositories\Admin;

use App\Models\CarAttribute;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CarAttributeRepository
 * @package App\Repositories\Admin
 * @version October 8, 2018, 5:01 am UTC
 *
 * @method CarAttribute findWithoutFail($id, $columns = ['*'])
 * @method CarAttribute find($id, $columns = ['*'])
 * @method CarAttribute first($columns = ['*'])
*/
class CarAttributeRepository extends BaseRepository
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
        return CarAttribute::class;
    }
}
