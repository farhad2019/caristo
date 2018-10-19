<?php

namespace App\Repositories\Admin;

use App\Models\ReportRequest;
use Illuminate\Support\Facades\Auth;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ReportRequestRepository
 * @package App\Repositories\Admin
 * @version October 18, 2018, 9:10 am UTC
 *
 * @method ReportRequest findWithoutFail($id, $columns = ['*'])
 * @method ReportRequest find($id, $columns = ['*'])
 * @method ReportRequest first($columns = ['*'])
 */
class ReportRequestRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'car_id',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ReportRequest::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();
        $input['message'] = $input['message'] ?? null;
        $reportRequest = $this->create($input);
        return $reportRequest;
    }
}
