<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @property mixed $region
 * @property mixed $car
 */
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
    protected $with = [
        'region'
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
        'region',
        'price'
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function car()
    {
        return $this->belongsTo(MyCar::class);
    }

//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     */
//    public function region()
//    {
//        return $this->belongsTo(Region::class);
//    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region()
    {
        return $this->belongsTo(Region::class)->withTrashed();
    }
}
