<?php

namespace App\Models;

use App\Helper\Utils;
use Carbon\Carbon;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Zizaco\Entrust\Traits\EntrustUserTrait;

/**
 * @property integer id
 * @property integer model_id
 * @property integer type_id
 * @property integer engine_type_id
 * @property string name
 * @property string email
 * @property string country_code
 * @property integer phone
 * @property string chassis
 * @property string year
 * @property integer transmission_type
 * @property integer owner_id
 * @property integer owner_type
 * @property integer status
 * @property double kilometer
 * @property double amount
 * @property string bid_close_at
 * @property string limited_edition_specs
 * @property string depreciation_trend
 * @property string life_cycle
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property CarAttribute car_attributes
 * @property CarFeature car_features
 * @property User owner
 * @property CarType car_type
 * @property CarModel car_model
 * @property EngineType engine_type
 * @property Media media
 * @property MakeBid bids
 * @property RegionalSpecification regional_specs
 * @property CarAttribute my_car_attributes
 * @property CarFeature my_car_features
 * @property CarRegion car_regions
 * @property CarInteraction user_interactions
 * @property Category category
 * @property TradeInCar my_trade_cars
 * @property TradeInCar customer_trade_car
 *
 * @property string transmission_type_text
 * @property string top_bids
 * @property int views_count
 * @property bool is_liked
 * @property bool is_favorite
 * @property bool is_viewed
 * @property int is_reviewed
 * @property string ref_num
 * @property int liked_count
 * @property int favorite_count
 * @property mixed|null limited_edition_specs_array
 * @property mixed|null owner_type_text
 * @property array|null depreciation_trend_value
 * @property string link
 * @property string status_text
 * @property mixed|null front_image
 *
 * @SWG\Definition(
 *     definition="MyCarAttributes",
 *     @SWG\Property(
 *          property="KEY",
 *          description="KEY",
 *          type="string",
 *          default="VALUE"
 *     )
 * )
 *
 * @SWG\Definition(
 *      definition="MyCar",
 *      required={"model_id", "year", "name", "email", "country_code", "phone"},
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="email",
 *          description="email",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="country_code",
 *          description="country_code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="phone",
 *          description="phone",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="chassis",
 *          description="Car chassis number",
 *          type="string",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="kilometer",
 *          description="Car kilometer",
 *          type="number",
 *          format="float"
 *      ),
 *      @SWG\Property(
 *          property="model_id",
 *          description="Car Model Id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="year",
 *          description="car Model's year",
 *          type="string",
 *          default="2018",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="regional_specification_id",
 *          description="regional specification id",
 *          type="integer",
 *          format="int32"
 *      ),
 *     @SWG\Property(
 *          property="type_id",
 *          description="Type ID",
 *          type="integer",
 *          format="int32"
 *      ),
 *     @SWG\Property(
 *          property="engine_type_id",
 *          description="Engine Type Id",
 *          type="integer",
 *          format="int32"
 *      ),
 *     @SWG\Property(
 *          property="transmission_type",
 *          description="10=Manual:20=Automatic",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="car_attributes",
 *          description="attributes id - CSV [1,2,3]",
 *          type="array",
 *          @SWG\Items(ref="#/definitions/MyCarAttributes")
 *      ),
 *      @SWG\Property(
 *          property="car_features",
 *          description="Features id",
 *          type="array",
 *          @SWG\Items(type="integer")
 *      ),
 *      @SWG\Property(
 *          property="media",
 *          description="attach car media here",
 *          type="array",
 *          @SWG\Items(type="file")
 *      ),
 *      @SWG\Property(
 *          property="notes",
 *          description="add if any extra notes",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="deleted_images",
 *          description="images id, CSV",
 *          type="string"
 *      )
 * )
 */
class MyCar extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

//    use SoftDeletes {
//        restore as private restoreA;
//    }
//    use EntrustUserTrait {
//        restore as private restoreB;
//    }
    //protected $cascadeDeletes = ['myCarAttributes', 'views', 'likes', 'favorites', 'carRegions', 'customer_trade_car', 'my_trade_cars'];

    public $table = 'cars';
    protected $dates = ['deleted_at', 'bid_close_at'];

    const CAR_LIMIT = 15;
    const FEATURED_CAR_LIMIT = 5;

    const ACTIVE = 10;
    const INACTIVE = 20;
    const SOLD = 30;

    public static $STATUS = [
        self::ACTIVE => 'Active',
        self::INACTIVE => 'In Active',
        self::SOLD => 'Sold'
    ];

    public static $MEDIA_TYPES = [
        'front' => 'front',
        'back' => 'back',
        'right' => 'right',
        'left' => 'left',
        'interior' => 'interior',
        'registration card' => 'registration_card'
    ];

    const MANUAL = 10;
    const AUTOMATIC = 20;

    const SHOWROOM = 10;
    const USER = 20;

    const OUTLET_MALL = 25;
    const APPROVED_PRE_OWNED = 26;
    const CLASSIC_CARS = 27;
    const LIMITED_EDITION = 28;

    const FOURWD = '4WD';
    const AWD = 'AWD';
    const FWD = 'FWD';
    const RWD = 'RWD';

    public static $TRANSMISSION_TYPE_TEXT = [
        self::MANUAL => 'Manual',
        self::AUTOMATIC => 'Automatic'
    ];

    public static $DRIVE_TRAIN = [
        self::FOURWD => '4WD',
        self::AWD => 'AWD',
        self::FWD => 'FWD',
        self::RWD => 'RWD',
    ];

    public static $OWNER_TYPE_TEXT = [
        self::SHOWROOM => 'Vendor',
        self::USER => 'Client'
    ];

    public $fillable = [
        'is_featured',
        'views_count',
        'favorite_count',
        'like_count',
        'type_id',
        'model_id',
        'engine_type_id',
        'year',
        'chassis',
        'transmission_type',
        'name',
        'email',
        'country_code',
        'phone',
        'owner_id',
        'notes',
        'regional_specification_id',
        'owner_type',
        'average_mkp',
        'currency',
        'amount',
        'kilometer',
        'bid_close_at',
        'region',
        'category_id',
        'description',
        'limited_edition_specs',
        'depreciation_trend',
        'life_cycle',
        'call_clicks',
        'personal_shopper_clicks',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
            'amount' => 'integer' //on request of IOS developers
    ];

    /**
     * The objects that should be append to toArray.
     *
     * @var array
     */
    protected $with = [
        'owner',
        'carModel',
        'carType',
        'media',
        'myCarAttributes',
        'regionalSpecs',
        'carRegions',
        'category',
        'reviews',
        'engineType'
//        'myCarFeatures',
//        'bids',
    ];

    /**
     * The attributes that should be append to toArray.
     *
     * @var array
     */
    protected $appends = [
        'is_reviewed',
        'transmission_type_text',
        'link',
        'status_text',
        'owner_type_text',
//        'views_count',
        'top_bids',
        'is_liked',
        'is_viewed',
        'is_favorite',
        'limited_edition_specs_array',
        'depreciation_trend_value',
        'review_count',
        'ref_num'
    ];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'name',
        'email',
        'average_rating',
        'country_code',
        'version',
        'phone',
        'year',
        'currency',
        'amount',
        'average_mkp',
        'chassis',
        'kilometer',
        'notes',
        'ref_num',
        'link',
        'is_reviewed',
        'transmission_type_text',
        'owner_type_text',
        'review_count',
        'is_liked',
        'is_viewed',
        'views_count',
        'favorite_count',
        'call_clicks',
        'personal_shopper_clicks',
        'like_count',
        'is_favorite',
        'bid_close_at',
        'depreciation_trend_value',
        'life_cycle',
        'created_at',
//        'bids',
//        'carFeatures',
//        'myCarFeatures',
//        'carAttributes',
        'is_featured',
        'status',
        'status_text',
        'owner',
        'engineType',
        'carType',
        'carModel',
        'carRegions',
        'media',
        'top_bids',
        'regionalSpecs',
        'myCarAttributes',
        'category',
        'limited_edition_specs_array',
        'reviews',
        'specification'
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'media.*' => 'sometimes|image|mimes:jpg,jpeg,png',
        'country_code' => 'required',
        'phone' => 'required',
        'model_id' => 'required|exists:car_models,id',
        'engine_type_id' => 'required|exists:engine_types,id',
        'year' => 'required',
        'regional_specification_id' => 'required|exists:regional_specifications,id'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'name' => 'required',
        'email' => 'required|email',
        'media.*' => 'sometimes|image|mimes:jpg,jpeg,png',
        'country_code' => 'required',
        'phone' => 'required',
        'model_id' => 'required|exists:car_models,id',
        'engine_type_id' => 'required|exists:engine_types,id',
        'year' => 'required',
        'regional_specification_id' => 'required|exists:regional_specifications,id'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'name' => 'required',
        'email' => 'required|email',
        'country_code' => 'required',
        'phone' => 'required',
        'model_id' => 'required|exists:car_models,id',
        'year' => 'required',
        'regional_specification_id' => 'required|exists:regional_specifications,id',
//        'type_id'                   => 'required|exists:car_types,id',
//        'engine_type_id'            => 'sometimes|exists:engine_types,id',
//        'car_attributes.*.*' => 'required|exists:attributes,id',
//        'car_features.*'     => 'required|exists:features,id',
//        'transmission_type'         => 'required|in:10,20'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_updating_rules = [
        'name' => 'required',
        'email' => 'required|email',
        'country_code' => 'required',
        'phone' => 'required',
        'type_id' => 'required|exists:car_types,id',
        'model_id' => 'required|exists:car_models,id',
//        'engine_type_id'    => 'required|exists:engine_types,id',
        'year' => 'required',
//        'transmission_type' => 'required|in:10,20'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function media()
    {
        return $this->morphMany(Media::class, 'instance');
    }

    /**
     * @return string
     */
    public function getMorphClass()
    {
        return 'car';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function carAttributes()
    {
        return $this->belongsToMany(CarAttribute::class, 'car_attributes', 'car_id', 'attribute_id', 'id', 'id')->withPivot('value');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function myCarAttributes()
    {
        return $this->hasMany(MyCarAttribute::class, 'car_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function carFeatures()
    {
        return $this->belongsToMany(CarFeature::class, 'car_features', 'car_id', 'feature_id', 'id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function myCarFeatures()
    {
        return $this->hasMany(MyCarFeature::class, 'car_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function carModel()
    {
        return $this->belongsTo(CarModel::class, 'model_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function carType()
    {
        return $this->belongsTo(CarType::class, 'type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function engineType()
    {
        return $this->belongsTo(EngineType::class, 'engine_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function regionalSpecs()
    {
        return $this->belongsTo(RegionalSpecification::class, 'regional_specification_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
//    public function bids()
//    {
//        return $this->hasMany(MakeBid::class, 'car_id');
//    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    /* public function getTopBidsAttribute()
     {
         return null;
 //        return $this->bids()
 //            ->orderBy('created_at', 'desc')
 //            ->take(5)
 //            ->get();
     }*/

    /**
     * @return mixed
     */
    public function getTransmissionTypeTextAttribute()
    {
        return ($this->transmission_type) ? self::$TRANSMISSION_TYPE_TEXT[$this->transmission_type] : null;
    }

    /**
     * @return mixed|null
     */
    public function getOwnerTypeTextAttribute()
    {
        return ($this->owner_type) ? self::$OWNER_TYPE_TEXT[$this->owner_type] : null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function views()
    {
        return $this->hasMany(CarInteraction::class, 'car_id')->where('type', CarInteraction::TYPE_VIEW);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(CarInteraction::class, 'car_id')->where('type', CarInteraction::TYPE_LIKE);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favorites()
    {
        return $this->hasMany(CarInteraction::class, 'car_id')->where('type', CarInteraction::TYPE_FAVORITE);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function CarInteractions()
    {
        return $this->hasMany(CarInteraction::class, 'car_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function carRegions()
    {
        return $this->hasMany(CarRegion::class, 'car_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function myTradeCars()
    {
        return $this->hasMany(TradeInCar::class, 'owner_car_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bids()
    {
        return $this->hasMany(TradeInCar::class, 'customer_car_id')->orderBy('updated_at', 'DESC')->without(['tradeAgainst', 'myCar']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'car_id')->orderBy('created_at', 'DESC');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function DepreciationTrend()
    {
        return $this->hasMany(DepreciationTrend::class, 'car_id')->orderBy('year', 'ASC');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
//    public function customerTradeCar()
//    {
//        return $this->hasMany(TradeInCar::class, 'customer_car_id');
//    }

    /**
     * @return int
     */
//    public function getFavoriteCountAttribute()
//    {
//        return $this->favorites()->count();
//    }
//
//    /**
//     * @return int
//     */
//    public function getViewsCountAttribute()
//    {
//        return $this->views()->count();
//    }
//
//    /**
//     * @return int
//     */
//    public function getLikedCountAttribute()
//    {
//        return $this->likes()->count();
//    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTopBidsAttribute()
    {
        return $this->bids()
            ->whereHas('evaluationDetails', function ($evaluationDetails) {
                return $evaluationDetails->orderBy('amount', 'DESC')
                    ->take(5);
            })->with('evaluationDetails')
            ->get()->makeVisible('evaluationDetails');
    }

    /**
     * @return bool
     */
    public function getIsLikedAttribute()
    {
        return ($this->likes()->where('user_id', \Auth::id())->first() != null);
    }

    /**
     * @return bool
     */
    public function getIsFavoriteAttribute()
    {
        return ($this->favorites()->where('user_id', \Auth::id())->first() != null);
    }

    /**
     * @return bool
     */
    public function getIsViewedAttribute()
    {
        return ($this->views()->where('user_id', \Auth::id())->first() != null);
    }

    /**
     * @return string
     */
    public function getRefNumAttribute()
    {
        $refNum = date('Ym');
        return $refNum . sprintf("%05d", $this->id);
    }

    /**
     * @return string
     */
    public function getLimitedEditionSpecsArrayAttribute()
    {
        if (!empty($this->limited_edition_specs)) {
            $array = json_decode($this->limited_edition_specs, true);

            foreach ($array as $key => $items) {
                $count = 0;
                foreach ($items as $name => $item) {
                    $specs[$key][$count]['name'] = $name;
                    $specs[$key][$count]['value'] = $item;
                    $count++;
                }
            }
            return $specs;
        } else
            return null;
    }

    /**
     * @return array|null
     */
    public function getDepreciationTrendValueAttribute()
    {
        if (!empty($this->depreciation_trend)) {
            $depreciation = [];
            $depreciation_trend_amount = ($this->amount * $this->depreciation_trend) / 100;
            $year = Carbon::now();
            $current_year = $year->format('Y');
            $yearLists = [(int)$current_year, ((int)$current_year + 1), ((int)$current_year + 2), ((int)$current_year + 3)];

            foreach ($yearLists as $key => $yearList) {
                $depreciation[$key] = [
                    'year' => $yearList,
                    'amount' => $this->amount - ($key * $depreciation_trend_amount)
                ];
            }
            return $depreciation;
        } else {
            return null;
        }
    }

    /**
     * @return string
     */
    public function getLinkAttribute()
    {
        return url('deepLink.php') . '?type=' . Utils::CAR_DEEP_LINK . '&id=' . $this->id;
    }

    /**
     * @return string
     */
    public function getStatusTextAttribute()
    {
        return self::$STATUS[$this->status];
    }

    /**
     * @return mixed|null
     */
    public function getFrontImageAttribute()
    {
        return !empty($this->media()->where('title', 'front')->first()) ? $this->media()->where('title', 'front')->first()->file_url : null;
    }

    /**
     * @return mixed|null
     */
    public function getIsReviewedAttribute()
    {
        return ($this->reviews()->where('user_id', Auth::id())->count() > 0) ? 1 : 0;
    }

    /**
     * @return mixed|null
     */
    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }
}