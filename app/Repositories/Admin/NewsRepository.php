<?php

namespace App\Repositories\Admin;

use App\Models\News;
use Illuminate\Http\Request;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class NewsRepository
 * @package App\Repositories\Admin
 * @version August 10, 2018, 11:15 am UTC
 *
 * @method News findWithoutFail($id, $columns = ['*'])
 * @method News find($id, $columns = ['*'])
 * @method News first($columns = ['*'])
 */
class NewsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'category_id',
        'views_count',
        'favorite_count',
        'like_count',
        'comments_count',
        'created_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return News::class;
    }

    public function getCategoryWiseNews($catId)
    {
        return News::where('category_id', $catId)->get();
    }

    public function createRecord(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = \Auth::id();
        return $this->create($input);
    }

    public function updateRecord(Request $request, $id)
    {
        $input = $request->all();
        return $this->update($input, $id);
    }
}
