<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 * @property double kilometre
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property string transmission_type_text
 * @property string top_bids
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
 *          property="kilometre",
 *          description="Car kilometre",
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
 *      )
 * )
 */
class MyCar extends Model
{
    use SoftDeletes;

    public $table = 'cars';

    protected $dates = ['deleted_at'];

    const MANUAL = 10;
    const AUTOMATIC = 20;

    public static $TRANSMISSION_TYPE_TEXT = [
        self::MANUAL    => 'Manual',
        self::AUTOMATIC => 'Automatic'
    ];

    public $fillable = [
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
        'amount',
        'kilometre',
        'category_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

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
//        'bids',
        'engineType'
    ];

    /**
     * The attributes that should be append to toArray.
     *
     * @var array
     */
    protected $appends = [
//        'transmission_type_text'
        'top_bids'
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
        'country_code',
        'phone',
        'year',
//        'transmission_type_text',
        'engineType',
        'carType',
        'carModel',
        'owner',
        'media',
//        'bids',
        'chassis',
        'kilometre',
        'top_bids',
        'created_at'
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'name'                      => 'required',
        'email'                     => 'required|email',
        'country_code'              => 'required',
        'phone'                     => 'required',
        'model_id'                  => 'required|exists:car_models,id',
        'engine_type_id'            => 'required|exists:engine_types,id',
        'year'                      => 'required',
        'regional_specification_id' => 'required|exists:regional_specifications,id'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'type_id'           => 'required|exists:car_types,id',
        'model_id'          => 'required|exists:car_models,id',
        'engine_type_id'    => 'required|exists:engine_types,id',
        'year'              => 'required',
        'transmission_type' => 'required|in:10,20',
        'name'              => 'required',
        'email'             => 'required|email',
        'country_code'      => 'required',
        'phone'             => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'name'                      => 'required',
        'email'                     => 'required|email',
        'country_code'              => 'required',
        'phone'                     => 'required',
        'model_id'                  => 'required|exists:car_models,id',
        'year'                      => 'required',
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
        'name'              => 'required',
        'email'             => 'required|email',
        'country_code'      => 'required',
        'phone'             => 'required',
        'type_id'           => 'required|exists:car_types,id',
        'model_id'          => 'required|exists:car_models,id',
        'engine_type_id'    => 'required|exists:engine_types,id',
        'year'              => 'required',
        'transmission_type' => 'required|in:10,20'
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function carFeatures()
    {
        return $this->belongsToMany(CarFeature::class, 'car_features', 'car_id', 'feature_id', 'id', 'id');
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
    public function bids()
    {
        return $this->hasMany(MakeBid::class, 'car_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function getTopBidsAttribute()
    {
        return $this->bids()->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }

    /**
     * @return mixed
     */
    public function getTransmissionTypeTextAttribute()
    {
        return ($this->transmission_type) ? self::$TRANSMISSION_TYPE_TEXT[$this->transmission_type] : null;
    }
}