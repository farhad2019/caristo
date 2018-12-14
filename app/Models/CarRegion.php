<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

///**
// * @property integer id
// * @property string created_at
// * @property string updated_at
// * @property string deleted_at
// *
// * @property MyCar cars
// * @SWG\Definition(
// *      definition="CarRegion",
// *      required={"id"},
// *      @SWG\Property(
// *          property="id",
// *          description="id",
// *          type="integer",
// *          format="int32"
// *      )
// * )
// */
class CarRegion extends Model
{
    use SoftDeletes;

    public $table = 'car_regions';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'car_id',
        'region_id',
        'price',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'        => 'int',
        'car_id'    => 'int',
        'region_id' => 'int',
        'price'     => 'varchar',

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
    protected $visible = [

    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
//        'car_id'    => 'required',
//        'region_id' => 'required',
//        'price'     => 'required',
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
//        'car_id'    => 'required',
//        'region_id' => 'required',
//        'price'     => 'required',
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
//        'car_id'    => 'required',
//        'region_id' => 'required',
//        'price'     => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
   public function regionCar(){
       return $this->belongsTo(MyCar::class);
   }
    public function region()
    {
       return $this->belongsTo(Region::class);
    }
}
