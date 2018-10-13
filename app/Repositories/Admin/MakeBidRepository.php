<?php

namespace App\Repositories\Admin;

use App\Models\MakeBid;
use App\Models\MyCar;
use Illuminate\Support\Facades\Auth;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MakeBidRepository
 * @package App\Repositories\Admin
 * @version October 12, 2018, 1:16 pm UTC
 *
 * @method MakeBid findWithoutFail($id, $columns = ['*'])
 * @method MakeBid find($id, $columns = ['*'])
 * @method MakeBid first($columns = ['*'])
 */
class MakeBidRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'car_id',
        'user_id',
        'amount'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MakeBid::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->only('amount', 'car_id');
        $input['user_id'] = Auth::id();
        $bid = $this->create($input);
        return $bid;
    }
}
