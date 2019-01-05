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
        if ($request->category_id == MyCar::LIMITED_EDITION) {
            $limited = array(
                'Dimensions_Weight'    => array(
                    'LENGTH'              => $request->length,
                    'WIDTH'               => $request->width,
                    'HEIGHT'              => $request->height,
                    'WEIGHT DISTRIBUTION' => $request->weight_dist,
                    'TRUNK'               => $request->trunk,
                    'WEIGHT'              => $request->weight,
                ),
                'Seating_Capacity'     => array(
                    'MAX.NO OF SEATS' => $request->seats,
                ),
                'Drivetrain'           => array(
                    'DRIVETRAIN' => $request->drivetrain,
                ),
                'Engine'               => array(
                    'DISPLACEMENT'    => $request->displacement,
                    'NO. OF CYLINDER' => $request->clynders,
                ),
                'Performance'          => array(
                    'MAX SPEED'          => $request->max_speed,
                    'ACCELERATION 0-100' => $request->acceleration,
                    'HP / RPM'           => $request->hp_rpm,
                    'TORQUE'             => $request->torque,
                ),
                'Transmission '        => array(
                    'GEARBOX' => $request->gearbox,
                ),
                'Brakes'               => array(
                    'BRAKES SYSTEM' => $request->brakes,
                ),
                'Suspension'           => array(
                    'SUSPENSION' => $request->suspension,
                ),
                'Wheels_Tyres'         => array(
                    'FRONT TYRE' => $request->front_tyre,
                    'BACK TYRE'  => $request->back_tyre,
                ),
                'Fuel'                 => array(
                    'FUEL CONSUMPTION' => $request->consumbsion,
                ),
                'Emission'             => array(
                    'EMISSION' => $request->emission,
                ),
                'Warranty_Maintenance' => array(
                    'WARRANTY'             => $request->warranty,
                    'MAINTENANCE PROGRAM ' => $request->maintenance,
                ),
//                'Lifecycle'            => array(
//                    'LIFECYCLE' => $request->lifecycle,
//                ),
//                'Depreciation_Trend'   => array(
//                    'DEPRECIATION TREND' => $request->depreciation_trend,
//                )
            );
            $input['category_id'] = $request->category_id;
            $input['owner_id'] = $user->id;
            $input['owner_type'] = User::SHOWROOM_OWNER;

            $input['model_id'] = $request->model_id;
            $input['chassis'] = $request->chassis;
            $input['year'] = $request->year;
            $input['price'] = $request->price;
            $input['regional_specification_id'] = $request->regional_specification_id;
            $input['type_id'] = $request->type_id;
            $input['engine_type_id'] = $request->engine_type_id;
            $input['name'] = $request->name;
            $input['amount'] = $request->amount;
            $input['notes'] = $request->notes;
            $input['limited_edition_specs'] = json_encode($limited);
//            $from = date('Y', strtotime($request->from));
//            $to = date('Y', strtotime($request->to));
            $input['life_cycle'] = $request->from . '-' . $request->to;

            $input['depreciation_trend'] = $request->depreciation_trend;
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
            $input = $request->only(['type_id', 'model_id', 'year', 'transmission_type', 'engine_type_id', 'name', 'email', 'country_code', 'phone', 'chassis', 'notes', 'regional_specification_id', 'category_id', 'average_mkp', 'amount', 'kilometer', 'price', 'description']);
            $input['owner_id'] = $user->id;
            if (Auth::user()->hasRole(['showroom-owner', 'Administrators'])) {
                $user_type = User::SHOWROOM_OWNER;
            } else {
                $user_type = User::RANDOM_USER;
            }
            $input['owner_type'] = $user_type;

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
            $region = intval($request->region);
            if ($region) {
                $regions = [];
                $regions['region_id'] = $region;
                $regions['car_id'] = $myCar->id;
                CarRegion::create($regions);
            }

        }
        // Media Data
        if ($request->hasFile('media')) {
            $media = [];
            $mediaFiles = $request->file('media');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $key => $mediaFile) {
                $media[] = [
                    'title'    => $key,
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

    public function updateApiRecord($request, $myCar)
    {
        $input = $request->only(['type_id', 'model_id', 'year', 'engine_type_id', 'name', 'email', 'country_code', 'phone', 'chassis', 'notes', 'regional_specification_id', 'kilometer']);

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
    }

    /**
     * @param $request
     * @param $myCar
     * @return mixed
     */
    public function updateRecord($request, $myCar)
    {
        $input = $request->only(['type_id', 'model_id', 'year', 'transmission_type', 'engine_type_id', 'name', 'email', 'country_code', 'phone', 'kilometer', 'chassis', 'notes', 'regional_specification_id', 'category_id', 'average_mkp', 'amount', 'regions', 'price', 'description']);
        if ($request->category_id == MyCar::LIMITED_EDITION) {
            $limited = array(
                'Dimensions_Weight'    => array(
                    'LENGTH'              => $request->length,
                    'WIDTH'               => $request->width,
                    'HEIGHT'              => $request->height,
                    'WEIGHT DISTRIBUTION' => $request->weight_dist,
                    'TRUNK'               => $request->trunk,
                    'WEIGHT'              => $request->weight,
                ),
                'Seating_Capacity'     => array(
                    'MAX.NO OF SEATS' => $request->seats,
                ),
                'Drivetrain'           => array(
                    'DRIVETRAIN' => $request->drivetrain,
                ),
                'Engine'               => array(
                    'DISPLACEMENT'    => $request->displacement,
                    'NO. OF CYLINDER' => $request->clynders,
                ),
                'Performance'          => array(
                    'MAX SPEED'          => $request->max_speed,
                    'ACCELERATION 0-100' => $request->acceleration,
                    'HP / RPM'           => $request->hp_rpm,
                    'TORQUE'             => $request->torque,
                ),
                'Transmission '        => array(
                    'GEARBOX' => $request->gearbox,
                ),
                'Brakes'               => array(
                    'BRAKES SYSTEM' => $request->brakes,
                ),
                'Suspension'           => array(
                    'SUSPENSION' => $request->suspension,
                ),
                'Wheels_Tyres'         => array(
                    'FRONT TYRE' => $request->front_tyre,
                    'BACK TYRE'  => $request->back_tyre,
                ),
                'Fuel'                 => array(
                    'FUEL CONSUMPTION' => $request->consumbsion,
                ),
                'Emission'             => array(
                    'EMISSION' => $request->emission,
                ),
                'Warranty_Maintenance' => array(
                    'WARRANTY'             => $request->warranty,
                    'MAINTENANCE PROGRAM ' => $request->maintenance,
                ),
//                'Lifecycle'            => array(
//                    'LIFECYCLE' => $request->lifecycle,
//                ),
//                'Depreciation_Trend'   => array(
//                    'DEPRECIATION TREND' => $request->depreciation_trend,
//                )
            );
            $input['category_id'] = $request->category_id;
            //$input['owner_id'] = $user->id;
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
//            $from = date('Y', strtotime($request->from));
//            $to = date('Y', strtotime($request->to));
            $input['life_cycle'] = $request->from . '-' . $request->to;
            $input['depreciation_trend'] = $request->depreciation_trend;
            $myCar = $this->update($input, $myCar->id);
//            $input['region'] = $request->regions;
            $region = intval($request->regions);
            if (isset($input['category_id'])) {
                $regions = [];
                if ($region > 0) {
                    CarRegion::where('car_id', $myCar->id)->delete();
                    foreach ($request->regions as $key => $val) {
                        $regions['region_id'] = intval($request->regions[$key]);
                        $regions['price'] = $input['price'][$key];
                        $regions['car_id'] = $myCar->id;
                        CarRegion::create($regions);
                    }
                }
            }
        } else {
            $myCar = $this->update($input, $myCar->id);

            if ($input['category_id'] == MyCar::LIMITED_EDITION) {
                $regions = [];

                foreach ($input['regions'] as $key => $val) {
                    $id = intval($input['regions'][$key]);
                    $regions['price'] = $input['price'][$key];
                    $regions['car_id'] = $myCar->id;
                    CarRegion::where('id', $id)->update($regions);
                }


            }
        }

        // Media Data
        if ($request->hasFile('media')) {
            $media = [];
            $mediaFiles = $request->file('media');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $key => $mediaFile) {
                //$media[] = Utils::handlePicture($mediaFile);
                $media[] = [
                    'title'    => $key,
                    'filename' => Storage::putFile('media_files', $mediaFile)
                ];
            }

            $myCar->media()->createMany($media);
        }

        return $myCar;
    }
}
