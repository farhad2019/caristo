<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @SWG\Definition(
 *      definition="Car",
 *      required={"type_id", "category_id", "model_id", "engine_type_id", "regional_specification_id", "owner_id", "year", "chassis", "transmission_type", "kilometre", "average_mkp", "amount", "name", "email", "country_code", "phone", "owner_type", "notes"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="type_id",
 *          description="type_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="category_id",
 *          description="category_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="model_id",
 *          description="model_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="engine_type_id",
 *          description="engine_type_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="regional_specification_id",
 *          description="regional_specification_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="owner_id",
 *          description="owner_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="year",
 *          description="year",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="chassis",
 *          description="chassis",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="transmission_type",
 *          description="transmission_type",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="kilometre",
 *          description="kilometre",
 *          type="number",
 *          format="float"
 *      ),
 *      @SWG\Property(
 *          property="average_mkp",
 *          description="average_mkp",
 *          type="number",
 *          format="float"
 *      ),
 *      @SWG\Property(
 *          property="amount",
 *          description="amount",
 *          type="number",
 *          format="float"
 *      ),
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
 *          property="owner_type",
 *          description="owner_type",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="notes",
 *          description="notes",
 *          type="string"
 *      )
 * )
 */
class Car extends Model
{
    use SoftDeletes;

    public $table = 'cars';

    protected $dates = ['deleted_at'];
    
    public $fillable = [
        'type_id',
        'category_id',
        'model_id',
        'engine_type_id',
        'regional_specification_id',
        'owner_id',
        'year',
        'chassis',
        'transmission_type',
        'kilometre',
        'average_mkp',
        'amount',
        'name',
        'email',
        'country_code',
        'phone',
        'owner_type',
        'notes'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'year' => 'date',
        'chassis' => 'string',
        'transmission_type' => 'boolean',
        'kilometre' => 'float',
        'average_mkp' => 'float',
        'amount' => 'float',
        'name' => 'string',
        'email' => 'string',
        'country_code' => 'string',
        'owner_type' => 'boolean',
        'notes' => 'string'
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
        'type_id' => 'required',
        'category_id' => 'required',
        'model_id' => 'required',
        'engine_type_id' => 'required',
        'regional_specification_id' => 'required',
        'owner_id' => 'required',
        'year' => 'required',
        'chassis' => 'required',
        'transmission_type' => 'required',
        'kilometre' => 'required',
        'average_mkp' => 'required',
        'amount' => 'required',
        'name' => 'required',
        'email' => 'required',
        'country_code' => 'required',
        'phone' => 'required',
        'owner_type' => 'required',
        'notes' => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'type_id' => 'required',
        'category_id' => 'required',
        'model_id' => 'required',
        'engine_type_id' => 'required',
        'regional_specification_id' => 'required',
        'owner_id' => 'required',
        'year' => 'required',
        'chassis' => 'required',
        'transmission_type' => 'required',
        'kilometre' => 'required',
        'average_mkp' => 'required',
        'amount' => 'required',
        'name' => 'required',
        'email' => 'required',
        'country_code' => 'required',
        'phone' => 'required',
        'owner_type' => 'required',
        'notes' => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'type_id' => 'required',
        'category_id' => 'required',
        'model_id' => 'required',
        'engine_type_id' => 'required',
        'regional_specification_id' => 'required',
        'owner_id' => 'required',
        'year' => 'required',
        'chassis' => 'required',
        'transmission_type' => 'required',
        'kilometre' => 'required',
        'average_mkp' => 'required',
        'amount' => 'required',
        'name' => 'required',
        'email' => 'required',
        'country_code' => 'required',
        'phone' => 'required',
        'owner_type' => 'required',
        'notes' => 'required'
    ];

    
}
