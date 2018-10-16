<?php

namespace App\Repositories\Admin;

use App\Helper\Utils;
use App\Models\CarType;
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
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->only('name');
        $carType = $this->create($input);

        if ($request->hasFile('image')) {
            $media = [];
            $mediaFiles = $request->file('image');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $mediaFile) {
                $media[] = Utils::handlePicture($mediaFile);
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
        if ($request->hasFile('image')) {
            $media = [];
            $mediaFiles = $request->file('image');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $mediaFile) {
                $media[] = Utils::handlePicture($mediaFile);
            }
            $carType->media()->delete();
            $carType->media()->createMany($media);
        }
        return $carType;
    }
}