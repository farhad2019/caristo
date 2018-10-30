<?php

namespace App\Repositories\Admin;

use App\Helper\Utils;
use App\Models\MakeBid;
use App\Models\MyCar;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use InfyOm\Generator\Common\BaseRepository;
use Carbon\Carbon;

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

        if ($user->hasRole('showroom-owner')) {
            $input['owner_type'] = User::SHOWROOM_OWNER;
        }

        // current date + 1
        $date = Carbon::now()->addDay();

        // day name in string
        $day = $date->format('l');

        //matches is this day is weekend
        if (in_array($day, MakeBid::WEEK_END)) {

            // add 1 more day
            $expire_at = $date->addDay();

            // day name in string
            $expire_at_day = $expire_at->format('l');

            //matches is this day is weekend
            if (in_array($expire_at_day, MakeBid::WEEK_END)) {

                // add 1 more day
                $expire_at = $date->addDay();
            }
        } else {
            $expire_at = $date;
        }
        $input['bid_close_at'] = $expire_at;

        $myCar = $this->create($input);

        // Media Data
        if ($request->hasFile('media')) {
            $media = [];
            $mediaFiles = $request->file('media');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $mediaFile) {
                $media[] = [
                    'title'    => $mediaFile->getClientOriginalName(),
                    'filename' => Storage::putFile('media_files', $mediaFile)
                ]; //Utils::handlePicture($mediaFile);
                //$media[] = Utils::handlePicture($mediaFile);
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
        $input = $request->only(['type_id', 'model_id', 'year', 'transmission_type', 'engine_type_id', 'name', 'email', 'country_code', 'phone', 'chassis', 'notes', 'regional_specification_id', 'category_id', 'average_mkp', 'amount']);

        $myCar = $this->update($input, $myCar->id);

        // Media Data
        if ($request->hasFile('media')) {
            $media = [];
            $mediaFiles = $request->file('media');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $mediaFile) {
                $media[] = Utils::handlePicture($mediaFile);
            }

            $myCar->media()->createMany($media);
        }
        return $myCar;
    }
}
