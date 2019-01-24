<?php

namespace App\Repositories\Admin;

use App\Models\DepreciationTrend;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DepreciationTrendRepository
 * @package App\Repositories\Admin
 * @version December 17, 2018, 5:49 am UTC
 *
 * @method DepreciationTrend findWithoutFail($id, $columns = ['*'])
 * @method DepreciationTrend find($id, $columns = ['*'])
 * @method DepreciationTrend first($columns = ['*'])
*/
class DepreciationTrendRepository extends BaseRepository
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
        return DepreciationTrend::class;
    }
}
