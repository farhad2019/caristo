<?php

namespace App\Repositories\Admin;

use App\Models\NewsInteraction;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class NewsInteractionRepository
 * @package App\Repositories\Admin
 * @version August 14, 2018, 10:11 am UTC
 *
 * @method NewsInteraction findWithoutFail($id, $columns = ['*'])
 * @method NewsInteraction find($id, $columns = ['*'])
 * @method NewsInteraction first($columns = ['*'])
*/
class NewsInteractionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'news_id',
        'type',
        'created_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return NewsInteraction::class;
    }
}
