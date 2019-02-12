<?php

namespace App\Repositories\Admin;

use App\Models\CarVersion;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CarVersionRepository
 * @package App\Repositories\Admin
 * @version February 12, 2019, 8:21 am UTC
 *
 * @method CarVersion findWithoutFail($id, $columns = ['*'])
 * @method CarVersion find($id, $columns = ['*'])
 * @method CarVersion first($columns = ['*'])
*/
class CarVersionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'model_id',
        'title'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CarVersion::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->all();
        $carVersion = $this->create($input);
        return $carVersion;
    }
}
