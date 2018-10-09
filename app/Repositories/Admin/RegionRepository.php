<?php

namespace App\Repositories\Admin;

use App\Models\Region;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RegionRepository
 * @package App\Repositories\Admin
 * @version October 8, 2018, 7:06 am UTC
 *
 * @method Region findWithoutFail($id, $columns = ['*'])
 * @method Region find($id, $columns = ['*'])
 * @method Region first($columns = ['*'])
*/
class RegionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Region::class;
    }
}
