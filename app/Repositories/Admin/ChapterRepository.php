<?php

namespace App\Repositories\Admin;

use App\Models\Chapter;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ChapterRepository
 * @package App\Repositories\Admin
 * @version February 26, 2019, 11:02 am UTC
 *
 * @method Chapter findWithoutFail($id, $columns = ['*'])
 * @method Chapter find($id, $columns = ['*'])
 * @method Chapter first($columns = ['*'])
*/
class ChapterRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'course_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Chapter::class;
    }
}
