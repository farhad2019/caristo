<?php

namespace App\Repositories\Admin;

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
                $media[] = $this->handlePicture($mediaFile);
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
                $media[] = $this->handlePicture($mediaFile);
            }
            $data->media()->createMany($media);
        }
        return $data;
    }


    private function handlePicture($mediaFile)
    {
        $rand = time();
        $filename = $rand . '.jpg';

        $path = implode(DIRECTORY_SEPARATOR, ['storage', 'app', 'media_files']);
        $basePath = base_path() . DIRECTORY_SEPARATOR . $path;

        $filePath = $path . DIRECTORY_SEPARATOR . $filename;
        $baseFilePath = base_path() . DIRECTORY_SEPARATOR . $filePath;

        $mediaFile->move($basePath, $mediaFile->getClientOriginalName());

        $image = Image::make($basePath . DIRECTORY_SEPARATOR . $mediaFile->getClientOriginalName());
        $image->save($baseFilePath, 'jpg', 100);
        unset($image);
        $image = null;
        unlink($basePath . DIRECTORY_SEPARATOR . $mediaFile->getClientOriginalName());
        return [
            'title'    => $mediaFile->getClientOriginalName(),
            'filename' => 'media_files/' . $filename
        ];
    }
}
