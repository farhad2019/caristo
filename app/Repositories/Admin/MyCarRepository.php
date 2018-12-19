<?php

namespace App\Repositories\Admin;

use App\Helper\Utils;
use App\Models\CarRegion;
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
        $user = Auth::user();
        if ($request->category_id == MyCar::LIMITEDADDITION) {
            $limited = array(
                'Dimensions_Weight'   =>
                    array(
                        'length'      => $request->length,
                        'width'       => $request->width,
                        'height'      => $request->height,
                        'weight_dist' => $request->weight_dist,
                        'trunk'       => $request->trunk,
                        'weight'      => $request->weight,
                    ),
                'Seating_Capacity'    => array(
                    'seats' => $request->seats,
                ),
                'Drivetrain'          => array(
                    'drivetrain' => $request->drivetrain,
                ),
                'Engine'              => array(
                    'displacement' => $request->displacement,
                    'clynders'     => $request->clynders,
                ),
                'Performance'         => array(
                    'max_speed'    => $request->max_speed,
                    'acceleration' => $request->acceleration,
                    'hp_rpm'       => $request->hp_rpm,
                    'torque'       => $request->torque,
                ),
                'Transmission'        => array(
                    'gearbox' => $request->gearbox,
                ),
                'Brakes'              => array(
                    'brakes' => $request->brakes,
                ),
                'Suspension'          => array(
                    'suspension' => $request->suspension,
                ),
                'Wheels_Tyres'        => array(
                    'front_tyre' => $request->front_tyre,
                    'back_tyre'  => $request->back_tyre,
                ),
                'Fuel'                => array(
                    'consumbsion' => $request->consumbsion,
                ),
                'Emission'            => array(
                    'emission' => $request->emission,
                ),
                'Warranty_Maintenace' => array(
                    'warranty'    => $request->warranty,
                    'maintenance' => $request->maintenance,
                ),
                'Lifecycle'           => array(
                    'lifecycle' => $request->lifecycle,
                ),
                'Depreciation_Trend'  => array(
                    'depreciation_trend' => $request->depreciation_trend,
                )
            );
            $input['category_id'] = $request->category_id;
            $input['owner_id'] = $user->id;
            $input['owner_type'] = User::SHOWROOM_OWNER;

            $input['model_id'] = $request->model_id;
            $input['year'] = $request->year;
            $input['price'] = $request->price;
            $input['regional_specification_id'] = $request->regional_specification_id;
            $input['type_id'] = $request->type_id;
            $input['engine_type_id'] = $request->engine_type_id;
            $input['name'] = $request->name;
            $input['amount'] = $request->amount;
            $input['notes'] = $request->notes;
            $input['limited_edition_specs'] = json_encode($limited);

            $myCar = $this->create($input);
//            $input['region'] = $request->regions;
            $region = intval($request->regions);
            if (isset($input['category_id'])) {
                $regions = [];
                if ($region > 0) {
                    foreach ($request->regions as $key => $val) {
                        $regions['region_id'] = intval($request->regions[$key]);
                        $regions['price'] = $input['price'][$key];
                        $regions['car_id'] = $myCar->id;
                        CarRegion::create($regions);
                    }
                }
            }
        } else {
            $input = $request->only(['type_id', 'model_id', 'year', 'transmission_type', 'engine_type_id', 'name', 'email', 'country_code', 'phone', 'chassis', 'notes', 'regional_specification_id', 'category_id', 'average_mkp', 'amount', 'kilometre', 'region', 'price', 'description', 'regions']);
            $input['owner_id'] = $user->id;
            $input['owner_type'] = User::SHOWROOM_OWNER;

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

            $region = intval($input['region']);
            $input['region'] = isset($region) ? $region : '';
            $myCar = $this->create($input);
            if (isset($input['category_id'])) {
                $regions = [];
                if ($regions > 0) {
                    $regions['region_id'] = $region;
                    $regions['car_id'] = $myCar->id;
                    CarRegion::create($regions);
                }
            }
        }
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
        $input = $request->only(['type_id', 'model_id', 'year', 'transmission_type', 'engine_type_id', 'name', 'email', 'country_code', 'phone', 'chassis', 'notes', 'regional_specification_id', 'category_id', 'average_mkp', 'amount', 'regions', 'price', 'description', 'region']);

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

        if ($input['category_id'] == MyCar::LIMITEDADDITION) {
            $regions = [];

            foreach ($input['regions'] as $key => $val) {
                $id = intval($input['regions'][$key]);
                $regions['price'] = $input['price'][$key];
                $regions['car_id'] = $myCar->id;
                CarRegion::where('id', $id)->update($regions);
            }


        }
        return $myCar;
    }
}
