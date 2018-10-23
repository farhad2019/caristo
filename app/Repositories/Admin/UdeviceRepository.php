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

    /**
     * @param $data
     * @return mixed
     */
    public function getByDeviceToken($data)
    {
        return $this->model->where('device_token', $data)->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function deleteByDeviceToken($data)
    {
        return $this->model->where('device_token', $data)->delete();
    }

    public function updatePushNotification($user_id, $push_notification)
    {
        $pushNotification = $this->model->where('user_id', $user_id)->update(['push_notification' => $push_notification]);
        return $pushNotification;
    }
}