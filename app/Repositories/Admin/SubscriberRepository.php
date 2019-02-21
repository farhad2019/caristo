<?php

namespace App\Repositories\Admin;

use App\Models\Subscriber;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SubscriberRepository
 * @package App\Repositories\Admin
 * @version February 21, 2019, 7:33 am UTC
 *
 * @method Subscriber findWithoutFail($id, $columns = ['*'])
 * @method Subscriber find($id, $columns = ['*'])
 * @method Subscriber first($columns = ['*'])
*/
class SubscriberRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'email'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Subscriber::class;
    }
}
