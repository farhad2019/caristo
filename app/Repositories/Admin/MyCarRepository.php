<?php

namespace App\Repositories\Admin;

use App\Models\MyCar;
use Illuminate\Support\Facades\Auth;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MyCarRepository
 * @package App\Repositories\Admin
 * @version October 8, 2018, 6:47 am UTC
 *
 * @method MyCar findWithoutFail($id, $columns = ['*'])
 * @method MyCar find($id, $columns = ['*'])
 * @method MyCar first($columns = ['*'])
 */
class MyCarRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'model_id',
        'year',
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MyCar::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->only(['type_id', 'model_id', 'year', 'transmission_type', 'engine_type_id', 'name', 'email', 'country_code', 'phone']);

        $user = Auth::user();
        $input['owner_id'] = $user->id;
        $input['owner_type'] = 20;

        if ($user->hasRole('showroom_owner')) {
            $input['owner_type'] = 10;
        }

        $myCar = $this->create($input);
        return $myCar;
    }

    /**
     * @param $request
     * @param $myCar
     * @return mixed
     */
    public function updateRecord($request, $myCar)
    {
        $input = $request->all();
        $myCar = $this->update($input, $myCar->id);
        return $myCar;
    }
}
