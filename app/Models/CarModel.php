<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property integer brand_id
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property CarBrand brand
 * @property MyCar cars
 *
 * @SWG\Definition(
 *      definition="CarModel",
 *      required={"brand_id", "created_at"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="brand_id",
 *          description="brand_id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class CarModel extends Model
{
    use SoftDeletes, Translatable;

    public $table = 'car_models';
    protected $dates = ['deleted_at'];
    protected $translatedAttributes = ['name'];

    public $fillable = [
        'brand_id',
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
        'brand'
    ];

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
    protected $visible = [
        'id',
        'name',
        'brand'
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'brand_id' => 'required|exists:brands,id',
        'name'     => 'required|max:20'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'brand_id' => 'required|exists:brands,id',
        'name'     => 'required|max:20'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'brand_id' => 'required|exists:brands,id',
        'name'     => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(CarBrand::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cars()
    {
        return $this->hasMany(MyCar::class, 'model_id');
    }
}
