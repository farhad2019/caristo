<?php

namespace App\Repositories\Admin;

use App\Models\Review;
use App\Models\ReviewDetail;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ReviewRepository
 * @package App\Repositories\Admin
 * @version January 11, 2019, 11:48 am UTC
 *
 * @method ReviewDetail findWithoutFail($id, $columns = ['*'])
 * @method ReviewDetail find($id, $columns = ['*'])
 * @method ReviewDetail first($columns = ['*'])
 */
class ReviewDetailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'review_id',
        'type_id',
        'rating'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ReviewDetail::class;
    }
}
