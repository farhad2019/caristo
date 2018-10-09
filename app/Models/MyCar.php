<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property string year
 * @property integer transmission_type
 * @property string country_code
 * @property string name
 * @property string email
 * @property integer owner_type
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property CarAttribute car_attributes
 * @property User owner
 *
 * @SWG\Definition(
 *     definition="MyCarAttributes",
 *     @SWG\Property(
 *          property="KEY",
 *          description="KEY",
 *          type="string",
 *          default="VALUE"
 *      )
 * )
 *
 * @SWG\Definition(
 *      definition="MyCar",
 *      required={"type_id", "model_id", "engine_type_id", "year", "transmission_type", "name", "email", "country_code", "phone"},
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
 *          property="type_id",
 *          description="Car Type Id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="model_id",
 *          description="Car Model Id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="engine_type_id",
 *          description="Car Engine Type Id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="year",
 *          description="car Model's year",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="transmission_type",
 *          description="transmission_type: 10:Manual, 20:Automatic",
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
 *      )
 * )
 */
class MyCar extends Model
{
    use SoftDeletes;

    public $table = 'cars';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'type_id',
        'model_id',
        'engine_type_id',
        'year',
        'transmission_type',
        'name',
        'email',
        'country_code',
        'phone',
        'owner_id',
        'owner_type'
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
    protected $with = [];

    /**
     * The attributes that should be append to toArray.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
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
}