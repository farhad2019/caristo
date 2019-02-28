<?php

namespace App\Repositories\Admin;

use App\Helper\Utils;
use App\Models\CarAttribute;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CarAttributeRepository
 * @package App\Repositories\Admin
 * @version October 8, 2018, 5:01 am UTC
 *
 * @method CarAttribute findWithoutFail($id, $columns = ['*'])
 * @method CarAttribute find($id, $columns = ['*'])
 * @method CarAttribute first($columns = ['*'])
 */
class CarAttributeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CarAttribute::class;
    }

    /**
     * @param $request
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function saveRecord($request)
    {
        $input = $request->only('name', 'type');
        $carAttribute = $this->create($input);

        if ($request->hasFile('icon')) {
            $media = [];
            $mediaFiles = $request->file('icon');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $mediaFile) {
                $media[] = Utils::handlePicture($mediaFile);
            }

            $carAttribute->media()->createMany($media);
        }
        return $carAttribute;
    }

    /**
     * @param $request
     * @param $carAttribute
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function updateRecord($request, $carAttribute)
    {
        $input = $request->only('name', 'type');
        $carAttribute = $this->update($input, $carAttribute->id);

        if ($request->hasFile('icon')) {
            $media = [];
            $mediaFiles = $request->file('icon');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $mediaFile) {
                $media[] = Utils::handlePicture($mediaFile);
            }
            $carAttribute->media()->delete();
            $carAttribute->media()->createMany($media);
        }
        return $carAttribute;
    }
}
