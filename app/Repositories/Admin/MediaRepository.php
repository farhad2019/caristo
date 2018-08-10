<?php

namespace App\Repositories\Admin;

use App\Models\Media;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MediaRepository
 * @package App\Repositories\Admin
 * @version August 10, 2018, 11:27 am UTC
 *
 * @method Media findWithoutFail($id, $columns = ['*'])
 * @method Media find($id, $columns = ['*'])
 * @method Media first($columns = ['*'])
*/
class MediaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'instance_id',
        'instance_type',
        'title',
        'filename',
        'created_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Media::class;
    }
}
