<?php

namespace App\Repositories\Admin;

use App\Helper\Utils;
use App\Models\Category;
use Illuminate\Http\Request;
use Image;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CategoryRepository
 * @package App\Repositories\Admin
 * @version August 9, 2018, 10:55 am UTC
 *
 * @method Category findWithoutFail($id, $columns = ['*'])
 * @method Category find($id, $columns = ['*'])
 * @method Category first($columns = ['*'])
 */
class CategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'slug',
    ];

    /**
     * 'created_at'
     * ];
     * Configure the Model
     **/
    public function model()
    {
        return Category::class;
    }

    public function getRootCategories()
    {
        return $this->findByField('parent_id', 0);
    }

    public function saveRecord(Request $request)
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
//                $media[] = $this->handlePicture($mediaFile);
                $media[] = Utils::handlePicture($mediaFile);
            }

            $data->media()->createMany($media);
        }
        return $data;
    }

    public function updateRecord($id, Request $request)
    {
        $input = $request->all();
        $input['user_id'] = \Auth::id();

        $data = $this->update($input, $id);
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

}
