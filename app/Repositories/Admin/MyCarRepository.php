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
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function saveRecord($request)
    {
        $user = Auth::user();
        if ($request->category_id == MyCar::LIMITED_EDITION) {
            $limited = array(
                'Dimensions_Weight'    => array(
                    'LENGTH'              => [
                        'value'        => $request->length,
                        'unit'         => $request->unit_length,
                        'is_highlight' => $request->highlight_length ?? 0
                    ],
                    'WIDTH'               => [
                        'value'        => $request->width,
                        'unit'         => $request->unit_width,
                        'is_highlight' => $request->highlight_width ?? 0
                    ],
                    'HEIGHT'              => [
                        'value'        => $request->height,
                        'unit'         => $request->unit_height,
                        'is_highlight' => $request->highlight_height ?? 0
                    ],
                    'WEIGHT DISTRIBUTION' => [
                        'value'        => $request->weight_dist,
                        'unit'         => $request->unit_weight_dist,
                        'is_highlight' => $request->highlight_weight_dist ?? 0
                    ],
                    'TRUNK'               => [
                        'value'        => $request->trunk,
                        'unit'         => $request->unit_trunk,
                        'is_highlight' => $request->highlight_trunk ?? 0
                    ],
                    'WEIGHT'              => [
                        'value'        => $request->weight,
                        'unit'         => $request->unit_weight,
                        'is_highlight' => $request->highlight_weight ?? 0
                    ],
                ),
                'Seating_Capacity'     => array(
                    'MAX.NO OF SEATS' => [
                        'value'        => $request->seats,
                        'unit'         => $request->unit_seats,
                        'is_highlight' => $request->highlight_seats ?? 0
                    ],
                ),
                'DRIVE_TRAIN'          => array(
                    'drive_train' => [
                        'value'        => $request->drive_train,
                        'unit'         => $request->unit_drive_train,
                        'is_highlight' => $request->highlight_drive_train ?? 0
                    ],
                ),
                'Engine'               => array(
                    'DISPLACEMENT'    => [
                        'value'        => $request->displacement,
                        'unit'         => $request->unit_displacement,
                        'is_highlight' => $request->highlight_displacement ?? 0
                    ],
                    'NO. OF CYLINDER' => [
                        'value'        => $request->cylinders,
                        'unit'         => $request->unit_cylinders,
                        'is_highlight' => $request->highlight_cylinders ?? 0
                    ],
                ),
                'Performance'          => array(
                    'MAX SPEED'          => [
                        'value'        => $request->max_speed,
                        'unit'         => $request->unit_max_speed,
                        'is_highlight' => $request->highlight_max_speed ?? 0
                    ],
                    'ACCELERATION 0-100' => [
                        'value'        => $request->acceleration,
                        'unit'         => $request->unit_acceleration,
                        'is_highlight' => $request->highlight_acceleration ?? 0
                    ],
                    'HP / RPM'           => [
                        'value'        => $request->hp_rpm,
                        'unit'         => $request->unit_hp_rpm,
                        'is_highlight' => $request->highlight_hp_rpm ?? 0
                    ],
                    'TORQUE'             => [
                        'value'        => $request->torque,
                        'unit'         => $request->unit_torque,
                        'is_highlight' => $request->highlight_torque ?? 0
                    ],
                ),
                'Transmission '        => array(
                    'GEARBOX' => [
                        'value'        => $request->gearbox,
                        'unit'         => $request->unit_gearbox,
                        'is_highlight' => $request->highlight_gearbox ?? 0
                    ],
                ),
                'Brakes'               => array(
                    'BRAKES SYSTEM' => [
                        'value'        => $request->brakes,
                        'unit'         => $request->unit_brakes,
                        'is_highlight' => $request->highlight_brakes ?? 0
                    ],
                ),
                'Suspension'           => array(
                    'SUSPENSION' => [
                        'value'        => $request->suspension,
                        'unit'         => $request->unit_suspension,
                        'is_highlight' => $request->highlight_suspension ?? 0
                    ],
                ),
                'Wheels_Tyres'         => array(
                    'FRONT TYRE' => [
                        'value'        => $request->front_tyre,
                        'unit'         => $request->unit_front_tyre,
                        'is_highlight' => $request->highlight_front_tyre ?? 0
                    ],
                    'REAR TYRE'  => [
                        'value'        => $request->back_tyre,
                        'unit'         => $request->unit_back_tyre,
                        'is_highlight' => $request->highlight_back_tyre ?? 0
                    ],
                ),
                'Fuel'                 => array(
                    'FUEL CONSUMPTION' => [
                        'value'        => $request->consumption,
                        'unit'         => $request->unit_consumption,
                        'is_highlight' => $request->highlight_consumption ?? 0
                    ],
                ),
                'Emission'             => array(
                    'EMISSION' => [
                        'value'        => $request->emission,
                        'unit'         => $request->unit_emission,
                        'is_highlight' => $request->highlight_emission ?? 0
                    ],
                ),
                'Warranty_Maintenance' => array(
                    'WARRANTY'             => [
                        'value'        => $request->warranty,
                        'unit'         => $request->unit_warranty,
                        'is_highlight' => $request->highlight_warranty ?? 0
                    ],
                    'MAINTENANCE PROGRAM ' => [
                        'value'        => $request->maintenance,
                        'unit'         => $request->unit_maintenance,
                        'is_highlight' => $request->highlight_maintenance ?? 0
                    ],
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
            $input['version_app'] = @$request->version_app;
            $input['version_id'] = $request->version_id;
            $input['model_id'] = $request->model_id;
            $input['chassis'] = $request->chassis;
            $input['year'] = date('Y');
            $input['price'] = $request->price;
            $input['regional_specification_id'] = $request->regional_specification_id;
            $input['type_id'] = $request->type_id;
            $input['engine_type_id'] = $request->engine_type_id;
            $input['name'] = $request->name;
            $input['currency'] = 'AED';
            $input['amount'] = $request->amount;
            $input['notes'] = $request->notes;
            $input['limited_edition_specs'] = json_encode($limited);
//            $from = date('Y', strtotime($request->from));
//            $to = date('Y', strtotime($request->to));
            $input['life_cycle'] = $request->from . '-' . $request->to;

            $input['depreciation_trend'] = 15;//$request->depreciation_trend;
            $myCar = $this->create($input);
//            $input['region'] = $request->regions;

            foreach ($request->regions as $key => $val) {
                $regions['region_id'] = (int)($key);
                $regions['price'] = $val;
                $regions['car_id'] = $myCar->id;
                CarRegion::create($regions);
            }

            /*  $region = intval($request->regions);
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
             }*/
        } else {
            $input = $request->only(['type_id', 'model_id', 'year', 'transmission_type', 'engine_type_id', 'version_id', 'name', 'email', 'country_code', 'phone', 'chassis', 'notes', 'regional_specification_id', 'category_id', 'average_mkp', 'amount', 'kilometer', 'price', 'description', 'is_featured', 'version_app']);

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

            $input['currency'] = @Auth::user()->details->regionDetail->currency ?? 'AED';
            $myCar = $this->create($input);
//            $region = intval($request->region);
//            if ($region) {
//                $regions = [];
//                $regions['region_id'] = Auth::user()->details->region_id;
//                $regions['car_id'] = $myCar->id;
            CarRegion::create(['region_id' => Auth::user()->details->region_id, 'car_id' => $myCar->id]);
//            }

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
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function updateApiRecord($request, $myCar)
    {
        $input = $request->only(['type_id', 'model_id', 'year', 'engine_type_id', 'name', 'version_id', 'email', 'country_code', 'phone', 'chassis', 'notes', 'regional_specification_id', 'kilometer', 'status', 'version_app']);

        $myCar = $this->update($input, $myCar->id);

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
//            foreach ($mediaFiles as $mediaFile) {
//                $media[] = Utils::handlePicture($mediaFile);
//            }

            $myCar->media()->createMany($media);
        }
    }

    /**
     * @param $request
     * @param $myCar
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function updateRecord($request, $myCar)
    {
        $input = $request->only(['type_id', 'model_id', 'year', 'transmission_type', 'engine_type_id', 'version_id', 'name', 'email', 'country_code', 'phone', 'kilometer', 'chassis', 'notes', 'regional_specification_id', 'category_id', 'average_mkp', 'currency', 'amount', 'regions', 'price', 'description', 'status', 'is_featured']);
        if ($request->category_id == MyCar::LIMITED_EDITION) {
            $limited = array(
                'Dimensions_Weight'    => array(
                    'LENGTH'              => [
                        'value'        => $request->length,
                        'unit'         => $request->unit_length,
                        'is_highlight' => $request->highlight_length ?? 0
                    ],
                    'WIDTH'               => [
                        'value'        => $request->width,
                        'unit'         => $request->unit_width,
                        'is_highlight' => $request->highlight_width ?? 0
                    ],
                    'HEIGHT'              => [
                        'value'        => $request->height,
                        'unit'         => $request->unit_height,
                        'is_highlight' => $request->highlight_height ?? 0
                    ],
                    'WEIGHT DISTRIBUTION' => [
                        'value'        => $request->weight_dist,
                        'unit'         => $request->unit_weight_dist,
                        'is_highlight' => $request->highlight_weight_dist ?? 0
                    ],
                    'TRUNK'               => [
                        'value'        => $request->trunk,
                        'unit'         => $request->unit_trunk,
                        'is_highlight' => $request->highlight_trunk ?? 0
                    ],
                    'WEIGHT'              => [
                        'value'        => $request->weight,
                        'unit'         => $request->unit_weight,
                        'is_highlight' => $request->highlight_weight ?? 0
                    ],
                ),
                'Seating_Capacity'     => array(
                    'MAX.NO OF SEATS' => [
                        'value'        => $request->seats,
                        'unit'         => $request->unit_seats,
                        'is_highlight' => $request->highlight_seats ?? 0
                    ],
                ),
                'DRIVE_TRAIN'          => array(
                    'drive_train' => [
                        'value'        => $request->drive_train,
                        'unit'         => $request->unit_drive_train,
                        'is_highlight' => $request->highlight_drive_train ?? 0
                    ],
                ),
                'Engine'               => array(
                    'DISPLACEMENT'    => [
                        'value'        => $request->displacement,
                        'unit'         => $request->unit_displacement,
                        'is_highlight' => $request->highlight_displacement ?? 0
                    ],
                    'NO. OF CYLINDER' => [
                        'value'        => $request->cylinders,
                        'unit'         => $request->unit_cylinders,
                        'is_highlight' => $request->highlight_cylinders ?? 0
                    ],
                ),
                'Performance'          => array(
                    'MAX SPEED'          => [
                        'value'        => $request->max_speed,
                        'unit'         => $request->unit_max_speed,
                        'is_highlight' => $request->highlight_max_speed ?? 0
                    ],
                    'ACCELERATION 0-100' => [
                        'value'        => $request->acceleration,
                        'unit'         => $request->unit_acceleration,
                        'is_highlight' => $request->highlight_acceleration ?? 0
                    ],
                    'HP / RPM'           => [
                        'value'        => $request->hp_rpm,
                        'unit'         => $request->unit_hp_rpm,
                        'is_highlight' => $request->highlight_hp_rpm ?? 0
                    ],
                    'TORQUE'             => [
                        'value'        => $request->torque,
                        'unit'         => $request->unit_torque,
                        'is_highlight' => $request->highlight_torque ?? 0
                    ],
                ),
                'Transmission '        => array(
                    'GEARBOX' => [
                        'value'        => $request->gearbox,
                        'unit'         => $request->unit_gearbox,
                        'is_highlight' => $request->highlight_gearbox ?? 0
                    ],
                ),
                'Brakes'               => array(
                    'BRAKES SYSTEM' => [
                        'value'        => $request->brakes,
                        'unit'         => $request->unit_brakes,
                        'is_highlight' => $request->highlight_brakes ?? 0
                    ],
                ),
                'Suspension'           => array(
                    'SUSPENSION' => [
                        'value'        => $request->suspension,
                        'unit'         => $request->unit_suspension,
                        'is_highlight' => $request->highlight_suspension ?? 0
                    ],
                ),
                'Wheels_Tyres'         => array(
                    'FRONT TYRE' => [
                        'value'        => $request->front_tyre,
                        'unit'         => $request->unit_front_tyre,
                        'is_highlight' => $request->highlight_front_tyre ?? 0
                    ],
                    'REAR TYRE'  => [
                        'value'        => $request->back_tyre,
                        'unit'         => $request->unit_back_tyre,
                        'is_highlight' => $request->highlight_back_tyre ?? 0
                    ],
                ),
                'Fuel'                 => array(
                    'FUEL CONSUMPTION' => [
                        'value'        => $request->consumption,
                        'unit'         => $request->unit_consumption,
                        'is_highlight' => $request->highlight_consumption ?? 0
                    ],
                ),
                'Emission'             => array(
                    'EMISSION' => [
                        'value'        => $request->emission,
                        'unit'         => $request->unit_emission,
                        'is_highlight' => $request->highlight_emission ?? 0
                    ],
                ),
                'Warranty_Maintenance' => array(
                    'WARRANTY'             => [
                        'value'        => $request->warranty,
                        'unit'         => $request->unit_warranty,
                        'is_highlight' => $request->highlight_warranty ?? 0
                    ],
                    'MAINTENANCE PROGRAM ' => [
                        'value'        => $request->maintenance,
                        'unit'         => $request->unit_maintenance,
                        'is_highlight' => $request->highlight_maintenance ?? 0
                    ],
                ),
//                'Lifecycle'            => array(
//                    'LIFECYCLE' => $request->lifecycle,
//                ),
//                'Depreciation_Trend'   => array(
//                    'DEPRECIATION TREND' => $request->depreciation_trend,
//                )
            );
            /*$limited = array(
                'Dimensions_Weight'    => array(
                    'LENGTH'              => [
                        'value'        => $request->length,
                        'is_highlight' => $request->highlight_length ?? 0
                    ],
                    'WIDTH'               => [
                        'value'        => $request->width,
                        'is_highlight' => $request->highlight_width ?? 0
                    ],
                    'HEIGHT'              => [
                        'value'        => $request->height,
                        'is_highlight' => $request->highlight_height ?? 0
                    ],
                    'WEIGHT DISTRIBUTION' => [
                        'value'        => $request->weight_dist,
                        'is_highlight' => $request->highlight_weight_dist ?? 0
                    ],
                    'TRUNK'               => [
                        'value'        => $request->trunk,
                        'is_highlight' => $request->highlight_trunk ?? 0
                    ],
                    'WEIGHT'              => [
                        'value'        => $request->weight,
                        'is_highlight' => $request->highlight_weight ?? 0
                    ],
                ),
                'Seating_Capacity'     => array(
                    'MAX.NO OF SEATS' => [
                        'value'        => $request->seats,
                        'is_highlight' => $request->highlight_seats ?? 0
                    ],
                ),
                'DRIVE_TRAIN'          => array(
                    'drive_train' => [
                        'value'        => $request->drive_train,
                        'is_highlight' => $request->highlight_drive_train ?? 0
                    ],
                ),
                'Engine'               => array(
                    'DISPLACEMENT'    => [
                        'value'        => $request->displacement,
                        'is_highlight' => $request->highlight_displacement ?? 0
                    ],
                    'NO. OF CYLINDER' => [
                        'value'        => $request->cylinders,
                        'is_highlight' => $request->highlight_cylinders ?? 0
                    ],
                ),
                'Performance'          => array(
                    'MAX SPEED'          => [
                        'value'        => $request->max_speed,
                        'is_highlight' => $request->highlight_max_speed ?? 0
                    ],
                    'ACCELERATION 0-100' => [
                        'value'        => $request->acceleration,
                        'is_highlight' => $request->highlight_acceleration ?? 0
                    ],
                    'HP / RPM'           => [
                        'value'        => $request->hp_rpm,
                        'is_highlight' => $request->highlight_hp_rpm ?? 0
                    ],
                    'TORQUE'             => [
                        'value'        => $request->torque,
                        'is_highlight' => $request->highlight_torque ?? 0
                    ],
                ),
                'Transmission '        => array(
                    'GEARBOX' => [
                        'value'        => $request->gearbox,
                        'is_highlight' => $request->highlight_gearbox ?? 0
                    ],
                ),
                'Brakes'               => array(
                    'BRAKES SYSTEM' => [
                        'value'        => $request->brakes,
                        'is_highlight' => $request->highlight_brakes ?? 0
                    ],
                ),
                'Suspension'           => array(
                    'SUSPENSION' => [
                        'value'        => $request->suspension,
                        'is_highlight' => $request->highlight_suspension ?? 0
                    ],
                ),
                'Wheels_Tyres'         => array(
                    'FRONT TYRE' => [
                        'value'        => $request->front_tyre,
                        'is_highlight' => $request->highlight_front_tyre ?? 0
                    ],
                    'REAR TYRE'  => [
                        'value'        => $request->back_tyre,
                        'is_highlight' => $request->highlight_back_tyre ?? 0
                    ],
                ),
                'Fuel'                 => array(
                    'FUEL CONSUMPTION' => [
                        'value'        => $request->consumption,
                        'is_highlight' => $request->highlight_consumption ?? 0
                    ],
                ),
                'Emission'             => array(
                    'EMISSION' => [
                        'value'        => $request->emission,
                        'is_highlight' => $request->highlight_emission ?? 0
                    ],
                ),
                'Warranty_Maintenance' => array(
                    'WARRANTY'             => [
                        'value'        => $request->warranty,
                        'is_highlight' => $request->highlight_warranty ?? 0
                    ],
                    'MAINTENANCE PROGRAM ' => [
                        'value'        => $request->maintenance,
                        'is_highlight' => $request->highlight_maintenance ?? 0
                    ],
                ),
//                'Lifecycle'            => array(
//                    'LIFECYCLE' => $request->lifecycle,
//                ),
//                'Depreciation_Trend'   => array(
//                    'DEPRECIATION TREND' => $request->depreciation_trend,
//                )
            );*/
            $input['category_id'] = $request->category_id;
            //$input['owner_id'] = $user->id;
            $input['owner_type'] = User::SHOWROOM_OWNER;

            $input['model_id'] = $request->model_id;
            $input['year'] = $request->year;
            $input['version_id'] = $request->version_id;
            $input['price'] = $request->price;
            $input['regional_specification_id'] = $request->regional_specification_id;
            $input['type_id'] = $request->type_id;
            $input['engine_type_id'] = $request->engine_type_id;
            $input['name'] = $request->name;
            $input['currency'] = 'AED';
            $input['amount'] = $request->amount;
            $input['notes'] = $request->notes;
            $input['limited_edition_specs'] = json_encode($limited);
//            $from = date('Y', strtotime($request->from));
//            $to = date('Y', strtotime($request->to));
            $input['life_cycle'] = $request->from . '-' . $request->to;
            $input['depreciation_trend'] = 15;//$request->depreciation_trend;
            $myCar = $this->update($input, $myCar->id);

            CarRegion::where('car_id', $myCar->id)->delete();
            foreach ($request->regions as $key => $val) {
                $regions['region_id'] = (int)($key);
                $regions['price'] = $val;
                $regions['car_id'] = $myCar->id;
                CarRegion::create($regions);
            }
//            $myCar->carRegions->updateExistingPivot();

            /* $input['region'] = $request->regions;
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
             }*/
        } else {
            $input['limited_edition_specs'] = null;
            $input['currency'] = @Auth::user()->details->regionDetail->currency ?? 'AED';
            $myCar = $this->update($input, $myCar->id);
            CarRegion::create(['region_id' => @Auth::user()->details->region_id, 'car_id' => $myCar->id]);

            /*if ($input['category_id'] == MyCar::LIMITED_EDITION) {
                $regions = [];

                foreach ($input['regions'] as $key => $val) {
                    $id = intval($input['regions'][$key]);
                    $regions['price'] = $input['price'][$key];
                    $regions['car_id'] = $myCar->id;
                    CarRegion::where('id', $id)->update($regions);
                }
            }*/
        }

        // Media Data
        if ($request->hasFile('media')) {
            $media = [];
            $mediaFiles = $request->file('media');
            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

            foreach ($mediaFiles as $key => $mediaFile) {
                $myCar->media()->where('title', $key)->delete();
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