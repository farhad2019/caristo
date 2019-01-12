<?php

namespace App\Repositories\Admin;

use App\Helper\Utils;
use App\Models\CarType;
use Illuminate\Support\Facades\Storage;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CarTypeRepository
 * @package App\Repositories\Admin
 * @version October 8, 2018, 5:58 am UTC
 *
 * @method CarType findWithoutFail($id, $columns = ['*'])
 * @method CarType find($id, $columns = ['*'])
 * @method CarType first($columns = ['*'])
 */
class CarTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CarType::class;
    }

    /**
     * @return mixed
     */
    public function getRootTypes()
    {
//        return $this->model->whereDoesntHave('news')->where('type', Category::NEWS)->get();
        return $this->model->whereDoesntHave('childCategory')->get();
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->only('name', 'parent_id');
        $carType = $this->create($input);

        if ($request->hasFile('image')) {
            $media = [];
            $mediaFiles = $request->file('image');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

//            foreach ($mediaFiles as $mediaFile) {
//                $media[] = Utils::handlePicture($mediaFile);
//            }

            foreach ($mediaFiles as $key => $mediaFile) {
                $media[] = [
                    'title'    => $key,
                    'filename' => Storage::putFile('media_files', $mediaFile)
                ]; //Utils::handlePicture($mediaFile);
                //$media[] = Utils::handlePicture($mediaFile);
            }

            $carType->media()->createMany($media);
        }
        return $carType;
    }

    /**
     * @param $request
     * @param $carType
     * @return mixed
     */
    public function updateRecord($request, $carType)
    {
        $input = $request->only('parent_id');
        $carType = $this->update($input, $carType->id);

        if ($request->hasFile('image')) {
            $media = [];
            $mediaFiles = $request->file('image');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

//            foreach ($mediaFiles as $mediaFile) {
//                $media[] = Utils::handlePicture($mediaFile);
//            }

            foreach ($mediaFiles as $key => $mediaFile) {
                $media[] = [
                    'title'    => $key,
                    'filename' => Storage::putFile('media_files', $mediaFile)
                ]; //Utils::handlePicture($mediaFile);
                //$media[] = Utils::handlePicture($mediaFile);

                $carType->media()->where(['instance_type' => 'carType', 'instance_id' => $carType->id, 'title' => $key])->delete();
            }

            //$carType->media()->delete();
            $carType->media()->createMany($media);
        }
        return $carType;
    }
}