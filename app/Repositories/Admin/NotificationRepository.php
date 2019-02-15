<?php

namespace App\Repositories\Admin;

use App\Models\Notification;
use App\Models\NotificationUser;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class NotificationRepository
 * @package App\Repositories\Admin
 * @version July 14, 2018, 6:54 am UTC
 *
 * @method Notification findWithoutFail($id, $columns = ['*'])
 * @method Notification find($id, $columns = ['*'])
 * @method Notification first($columns = ['*'])
 */
class NotificationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'url',
        'action_type',
        'ref_id',
        'message',
        'created_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Notification::class;
    }


    /**
     * @param $notification
     * @param $receiver_id
     * @return bool
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function notification($notification, $receiver_id)
    {
        $notification = $this->create($notification);

        NotificationUser::create([
            'notification_id' => $notification->id,
            'user_id'         => $receiver_id,
            'status'          => NotificationUser::STATUS_DELIVERED
        ]);

        return true;
    }
}