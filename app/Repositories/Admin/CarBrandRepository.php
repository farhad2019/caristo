<?php

namespace App\Repositories\Admin;

use App\Helper\Utils;
use App\Models\CarBrand;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CarBrandRepository
 * @package App\Repositories\Admin
 * @version October 5, 2018, 6:26 am UTC
 *
 * @method CarBrand findWithoutFail($id, $columns = ['*'])
 * @method CarBrand find($id, $columns = ['*'])
 * @method CarBrand first($columns = ['*'])
 */
class CarBrandRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'created_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CarBrand::class;
    }

    public function saveRecord($request)
    {
        $input = $request->all();
        $carBrand = $this->create($input);
        // Media Data
        if ($request->hasFile('media')) {
            $media = [];
            $mediaFiles = $request->file('media');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $mediaFile) {
//                $media[] = $this->handlePicture($mediaFile);
                $media[] = Utils::handlePicture($mediaFile);
            }

            $carBrand->media()->createMany($media);
        }
        return $carBrand;
    }

    public function updateRecord($request, $carBrand)
    {
        if ($request->hasFile('media')) {
            $media = [];
            $mediaFiles = $request->file('media');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $mediaFile) {
//                $media[] = $this->handlePicture($mediaFile);
                $media[] = Utils::handlePicture($mediaFile);
            }

            $carBrand->media()->createMany($media);
        }
        return $carBrand;
    }
}
