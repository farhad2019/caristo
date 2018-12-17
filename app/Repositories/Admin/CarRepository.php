<?php

namespace App\Repositories\Admin;

use App\Models\Car;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CarRepository
 * @package App\Repositories\Admin
 * @version December 17, 2018, 5:49 am UTC
 *
 * @method Car findWithoutFail($id, $columns = ['*'])
 * @method Car find($id, $columns = ['*'])
 * @method Car first($columns = ['*'])
*/
class CarRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'category_id',
        'model_id',
        'amount',
        'owner_type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Car::class;
    }
}
