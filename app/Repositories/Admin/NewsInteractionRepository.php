<?php

namespace App\Repositories\Admin;

use App\Models\NewsInteraction;
use Illuminate\Support\Facades\DB;
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
        'user_id',
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

    public function createOrUpdate($data)
    {
        return $this->updateOrCreate([
            'news_id' => $data['news_id'],
            'user_id' => $data['user_id'],
            'type'    => $data['type'],
        ], [
            'deleted_at' => DB::raw('NOW()')
        ]);
    }
}
