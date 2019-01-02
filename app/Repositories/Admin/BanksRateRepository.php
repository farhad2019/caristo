<?php

namespace App\Repositories\Admin;

use App\Helper\Utils;
use App\Models\BanksRate;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BanksRateRepository
 * @package App\Repositories\Admin
 * @version December 29, 2018, 8:15 am UTC
 *
 * @method BanksRate findWithoutFail($id, $columns = ['*'])
 * @method BanksRate find($id, $columns = ['*'])
 * @method BanksRate first($columns = ['*'])
*/
class BanksRateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'title',
        'phone_no',
        'address',
        'rate',
        'type',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BanksRate::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->all();
        $bankRate = $this->create($input);
        // Media Data
        if ($request->hasFile('media')) {
            $media = [];
            $mediaFiles = $request->file('media');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $mediaFile) {
//                $media[] = $this->handlePicture($mediaFile);
                $media[] = Utils::handlePicture($mediaFile);
            }

            $bankRate->media()->createMany($media);
        }
        return $bankRate;
    }

    /**
     * @param $request
     * @param $bankRate
     * @return mixed
     */
    public function updateRecord($request, $bankRate)
    {
        if ($request->hasFile('media')) {
            $media = [];
            $mediaFiles = $request->file('media');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $mediaFile) {
//                $media[] = $this->handlePicture($mediaFile);
                $media[] = Utils::handlePicture($mediaFile);
            }
            $bankRate->media()->delete();
            $bankRate->media()->createMany($media);
        }
        return $bankRate;
    }
}
