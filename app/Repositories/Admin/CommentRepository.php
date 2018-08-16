<?php

namespace App\Repositories\Admin;

use App\Models\Comment;
use Illuminate\Http\Request;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CommentRepository
 * @package App\Repositories\Admin
 * @version August 10, 2018, 11:25 am UTC
 *
 * @method Comment findWithoutFail($id, $columns = ['*'])
 * @method Comment find($id, $columns = ['*'])
 * @method Comment first($columns = ['*'])
 */
class CommentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'parent_id',
        'post_id',
        'user_id',
        'comment_text',
        'created_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Comment::class;
    }

    public function getNewsComments($newsId)
    {
        return Comment::where('news_id', $newsId)->get();
    }

    public function createRecord(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = \Auth::id();

        return $this->create($input);
    }
}
