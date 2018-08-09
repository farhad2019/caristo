<?php

namespace App\Repositories\Admin;

use App\Models\UserDevice;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UserRepository
 * @package App\Repositories\Admin
 * @version July 14, 2018, 9:11 am UTC
 *
 * @method UserDevice findWithoutFail($id, $columns = ['*'])
 * @method UserDevice find($id, $columns = ['*'])
 * @method UserDevice first($columns = ['*'])
 */
class UdeviceRepository extends BaseRepository
{
    /**
     * Returns specified model class name.
     *
     * @return string
     */
    public function model()
    {
        return UserDevice::class;
    }

    /***********************************************API***********************************************/

    public function getByDeviceToken($data)
    {
        return $this->model->where('device_token', $data)->get();
    }

    public function deleteByDeviceToken($data)
    {
        return $this->model->where('device_token', $data)->delete();
    }
}
