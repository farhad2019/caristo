<?php

namespace App\Repositories\Admin;

use App\Models\UserDetail;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UserdetailRepository
 * @package App\Repositories\Admin
 * @version April 2, 2018, 9:11 am UTC
 *
 * @method UserDetail findWithoutFail($id, $columns = ['*'])
 * @method UserDetail find($id, $columns = ['*'])
 * @method UserDetail first($columns = ['*'])
 */
class UserdetailRepository extends BaseRepository
{


    /**
     * Configure the Model
     **/
    public function model()
    {
        return UserDetail::class;
    }
}
