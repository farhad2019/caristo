<?php

namespace App\Repositories\Admin;

use App\Helper\Utils;
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
        $data = $this->create($input);
        // Media Data
        if ($request->hasFile('media')) {
            $media = [];
            $mediaFiles = $request->file('media');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $mediaFile) {
                $media[] = Utils::handlePicture($mediaFile);
            }

            $data->media()->createMany($media);
        }
        return $data;
    }

    /**
     * @param Request $request
     * @param News $news
     * @return mixed
     */
    public function updateRecord(Request $request, $news)
    {
        $input = $request->all();
        $data = $this->update($input, $id);
        // Media Data
        if ($request->hasFile('media')) {
            $media = [];
            $mediaFiles = $request->file('media');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $mediaFile) {
                $media[] = Utils::handlePicture($mediaFile);
            }
            // TODO: We are deleting all other media for now.
            $news->media()->delete();
            $data->media()->createMany($media);
        }
        return $data;
    }
}
