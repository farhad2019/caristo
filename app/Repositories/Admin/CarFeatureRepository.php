<?php

namespace App\Repositories\Admin;

use App\Helper\Utils;
use App\Models\CarFeature;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CarFeatureRepository
 * @package App\Repositories\Admin
 * @version October 8, 2018, 5:06 am UTC
 *
 * @method CarFeature findWithoutFail($id, $columns = ['*'])
 * @method CarFeature find($id, $columns = ['*'])
 * @method CarFeature first($columns = ['*'])
 */
class CarFeatureRepository extends BaseRepository
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
        return CarFeature::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->only('name');
        $carFeature = $this->create($input);

        if ($request->hasFile('icon')) {
            $media = [];
            $mediaFiles = $request->file('icon');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $mediaFile) {
                $media[] = Utils::handlePicture($mediaFile);
            }

            $carFeature->media()->createMany($media);
        }
        return $carFeature;
    }

    /**
     * @param $request
     * @param $carFeature
     * @return mixed
     */
    public function updateRecord($request, $carFeature)
    {
        if ($request->hasFile('icon')) {
            $media = [];
            $mediaFiles = $request->file('icon');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $mediaFile) {
                $media[] = Utils::handlePicture($mediaFile);
            }
            $carFeature->media()->delete();
            $carFeature->media()->createMany($media);
        }
        return $carFeature;
    }
}
