<?php

namespace App\Repositories\Admin;

use App\Helper\Utils;
use App\Models\UserShowroom;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UserShowroomRepository
 * @package App\Repositories\Admin
 * @version April 2, 2018, 9:11 am UTC
 *
 * @method UserShowroom findWithoutFail($id, $columns = ['*'])
 * @method UserShowroom find($id, $columns = ['*'])
 * @method UserShowroom first($columns = ['*'])
 */
class UserShowroomRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return UserShowroom::class;
    }

    public function updateRecord($request, $user_id)
    {
        $input = $request->showroom;
        $input['user_id'] = $user_id;
        $showroom = $this->model->updateOrCreate(['user_id' => $user_id], $input);

        // Media Data
        if ($request->hasFile('showroom_media')) {
            $showroom->media()->delete();
            $media = [];
            $mediaFiles = $request->file('showroom_media');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $mediaFile) {
//                $media[] = $this->handlePicture($mediaFile);
                $media[] = Utils::handlePicture($mediaFile);
            }

            $showroom->media()->createMany($media);

        }
        return $showroom;
    }
}