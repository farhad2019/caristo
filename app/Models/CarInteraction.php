<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property integer user_id
 * @property integer car_id
 * @property integer type
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property MyCar cars
 *
 * @SWG\Definition(
 *      definition="CarInteraction",
 *      required={"car_id", "type"},
 *      @SWG\Property(
 *          property="car_id",
 *          description="car_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="type",
 *          description="type, 10=View, 20=like, 30=favorite",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class CarInteraction extends Model
{
    use SoftDeletes;

    public $table = 'car_interactions';
    protected $dates = ['deleted_at'];

    const TYPE_VIEW = 10;
    const TYPE_LIKE = 20;
    const TYPE_FAVORITE = 30;
    const TYPE_CLICK_CATEGORY = 40;
    const TYPE_CLICK_PHONE = 45;
    const TYPE_CLICK_MYSHOPPER = 50;

    public static $TYPES = [
        self::TYPE_VIEW     => "Viewed",
        self::TYPE_LIKE     => "Like",
        self::TYPE_FAVORITE => "Favorite",
        self::TYPE_CLICK_CATEGORY => "Clicks",
    ];

    public $fillable = [
        'id',
        'user_id',
        'car_id',
        'type',
        'created_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'int',
        'car_id'  => 'int',
        'type'    => 'int'
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
        'user_id' => 'required',
        'car_id'  => 'required',
        'type'    => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'id'     => 'required',
        'car_id' => 'required',
        'type'   => 'required',
//        'user_id'    => 'required',
//        'created_at' => 'required',
//        'updated_at' => 'required',
//        'deleted_at' => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
//        'user_id' => 'required',
        'car_id' => 'required|exists:cars,id',
        'type'   => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cars()
    {
        return $this->belongsTo(MyCar::class);
    }
}
