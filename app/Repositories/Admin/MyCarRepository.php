<?php

namespace App\Repositories\Admin;

use App\Helper\Utils;
use App\Models\MyCar;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MyCarRepository
 * @package App\Repositories\Admin
 * @version October 8, 2018, 6:47 am UTC
 *
 * @method MyCar findWithoutFail($id, $columns = ['*'])
 * @method MyCar find($id, $columns = ['*'])
 * @method MyCar first($columns = ['*'])
 */
class MyCarRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'model_id',
        'year',
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MyCar::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->only(['type_id', 'model_id', 'year', 'transmission_type', 'engine_type_id', 'name', 'email', 'country_code', 'phone', 'chassis', 'notes', 'regional_specification_id', 'category_id', 'average_mkp', 'amount']);

        $user = Auth::user();
        $input['owner_id'] = $user->id;
        $input['owner_type'] = User::RANDOM_USER;

        if ($user->hasRole('showroom_owner')) {
            $input['owner_type'] = User::SHOWROOM_OWNER;
        }

        $myCar = $this->create($input);

        // Media Data
        if ($request->hasFile('media')) {
            $media = [];
            $mediaFiles = $request->file('media');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $mediaFile) {
//                $media[] = $this->handlePicture($mediaFile);
                $media[] = Utils::handlePicture($mediaFile);
            }

            $myCar->media()->createMany($media);
        }

        return $myCar;
    }

    /**
     * @param $request
     * @param $myCar
     * @return mixed
     */
    public function updateRecord($request, $myCar)
    {
        $input = $request->all();
        $myCar = $this->update($input, $myCar->id);
        return $myCar;
    }
}
