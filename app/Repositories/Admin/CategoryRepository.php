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

    /**
     * @return mixed
     */
    public function getRootCategories()
    {
//        return $this->model->whereDoesntHave('news')->where('type', Category::NEWS)->get();
        return $this->model->whereDoesntHave('news')->where('parent_id', 0)->where('type', Category::NEWS)->get();
    }

    /**
     * @return mixed
     */
    public function getRootCategories2()
    {
//        return $this->model->whereDoesntHave('news')->where('type', Category::NEWS)->get();
        return $this->model->where('parent_id', 0)->where('type', Category::NEWS)->get();
    }

    /**
     * @return mixed
     */
    public function getCarCategories()
    {
        return $this->model->where('type', Category::LUX_MARKET)->whereNotIn('parent_id', [0])->get();
    }

    /**
     * @param Request $request
     * @return mixed
     */
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

    /**
     * @param Category $category
     * @param Request $request
     * @return mixed
     */
    public function updateRecord($category, Request $request)
    {
        $input = $request->all();
        $input['user_id'] = \Auth::id();

        $data = $this->update($input, $category->id);
        // Media Data
        if ($request->hasFile('media')) {
            $media = [];
            $mediaFiles = $request->file('media');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $mediaFile) {
                $media[] = Utils::handlePicture($mediaFile);
            }

            // TODO: We are deleting all other media for now.
            $category->media()->delete();
            $category->media()->createMany($media);
        }
        return $data;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteRecord($id)
    {
        $this->delete($id);
        return $id;
    }
}