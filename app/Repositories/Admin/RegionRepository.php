<?php

namespace App\Repositories\Admin;

use App\Helper\Utils;
use App\Models\Region;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RegionRepository
 * @package App\Repositories\Admin
 * @version October 8, 2018, 7:06 am UTC
 *
 * @method Region findWithoutFail($id, $columns = ['*'])
 * @method Region find($id, $columns = ['*'])
 * @method Region first($columns = ['*'])
 */
class RegionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Region::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->all();
        $region = $this->create($input);

        // Media Data
        if ($request->hasFile('flag')) {
            $media = [];
            $mediaFiles = $request->file('flag');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $mediaFile) {
                $media[] = Utils::handlePicture($mediaFile);
            }

            $region->media()->createMany($media);
        }
        return $region;
    }

    public function updateRecord($request, $region)
    {
        $input = $request->all();
        $region = $this->update($input, $region->id);

        // Media Data
        if ($request->hasFile('flag')) {
            $media = [];
            $mediaFiles = $request->file('flag');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $mediaFile) {
                $media[] = Utils::handlePicture($mediaFile);
            }

            $region->media()->delete();
            $region->media()->createMany($media);
        }
        return $region;
    }
}
