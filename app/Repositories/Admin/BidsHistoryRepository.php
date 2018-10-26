<?php

namespace App\Repositories\Admin;

use App\Models\BidsHistory;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BidsHistoryRepository
 * @package App\Repositories\Admin
 * @version October 25, 2018, 1:35 pm UTC
 *
 * @method BidsHistory findWithoutFail($id, $columns = ['*'])
 * @method BidsHistory find($id, $columns = ['*'])
 * @method BidsHistory first($columns = ['*'])
*/
class BidsHistoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'engine_type_id',
        'regional_specification_id',
        'owner_id',
        'kilometre',
        'average_mkp',
        'amount',
        'name',
        'email',
        'country_code'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BidsHistory::class;
    }
}
