<?php

namespace App\Repositories\Admin;

use App\Models\RegionalSpecification;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RegionalSpecificationRepository
 * @package App\Repositories\Admin
 * @version October 10, 2018, 8:44 am UTC
 *
 * @method RegionalSpecification findWithoutFail($id, $columns = ['*'])
 * @method RegionalSpecification find($id, $columns = ['*'])
 * @method RegionalSpecification first($columns = ['*'])
*/
class RegionalSpecificationRepository extends BaseRepository
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
        return RegionalSpecification::class;
    }
}
