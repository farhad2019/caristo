<?php

namespace App\Repositories\Admin;

use App\Models\WalkThrough;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class WalkThroughRepository
 * @package App\Repositories\Admin
 * @version August 16, 2018, 9:23 am UTC
 *
 * @method WalkThrough findWithoutFail($id, $columns = ['*'])
 * @method WalkThrough find($id, $columns = ['*'])
 * @method WalkThrough first($columns = ['*'])
*/
class WalkThroughRepository extends BaseRepository
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
        return WalkThrough::class;
    }
}
