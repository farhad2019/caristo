<?php

namespace App\Repositories\Admin;

use App\Models\CarFeature;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CarFeatureRepository
 * @package App\Repositories\Admin
 * @version October 8, 2018, 5:06 am UTC
 *
 * @method CarFeature findWithoutFail($id, $columns = ['*'])
 * @method CarFeature find($id, $columns = ['*'])
 * @method CarFeature first($columns = ['*'])
*/
class CarFeatureRepository extends BaseRepository
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
        return CarFeature::class;
    }
}
