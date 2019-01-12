<?php

namespace App\Repositories\Admin;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ReviewRepository
 * @package App\Repositories\Admin
 * @version January 11, 2019, 11:48 am UTC
 *
 * @method Review findWithoutFail($id, $columns = ['*'])
 * @method Review find($id, $columns = ['*'])
 * @method Review first($columns = ['*'])
 */
class ReviewRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'user_id',
        'car_id',
        'average_rating'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Review::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();
        $review = $this->create($input);
        return $review;
    }

    /**
     * @param $request
     * @param $review
     * @return mixed
     */
    public function updateRecord($request, $review)
    {
        $input = $request->all();
        $review = $this->update($input, $review->id);
        return $review;
    }
}