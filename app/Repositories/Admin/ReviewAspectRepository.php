<?php

namespace App\Repositories\Admin;

use App\Models\ReviewAspect;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ReviewAspectRepository
 * @package App\Repositories\Admin
 * @version January 11, 2019, 11:43 am UTC
 *
 * @method ReviewAspect findWithoutFail($id, $columns = ['*'])
 * @method ReviewAspect find($id, $columns = ['*'])
 * @method ReviewAspect first($columns = ['*'])
 */
class ReviewAspectRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'created_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ReviewAspect::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->all();
        $reviewAspect = $this->create($input);
        return $reviewAspect;
    }

    /**
     * @param $request
     * @param $reviewAspect
     * @return mixed
     */
    public function updateRecord($request, $reviewAspect)
    {
        $input = $request->all();
        $reviewAspect = $this->update($input, $reviewAspect->id);
        return $reviewAspect;
    }
}
