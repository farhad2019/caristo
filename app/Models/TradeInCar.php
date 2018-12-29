<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property integer owner_car_id
 * @property integer customer_car_id
 * @property integer user_id
 * @property double amount
 * @property string notes
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property MyCar $trade_against
 * @property MyCar $my_car
 *
 * @SWG\Definition(
 *      definition="TradeInCar",
 *      required={"owner_car_id", "customer_car_id", "amount", "notes"},
 *      @SWG\Property(
 *          property="owner_car_id",
 *          description="owner_car_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="customer_car_id",
 *          description="customer_car_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="amount",
 *          description="amount",
 *          type="number",
 *          format="float"
 *      ),
 *      @SWG\Property(
 *          property="notes",
 *          description="notes",
 *          type="string"
 *      )
 * )
 */
class TradeInCar extends Model
{
    use SoftDeletes;

    public $table = 'trade_in_cars';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'owner_car_id',
        'customer_car_id',
        'user_id',
        'amount',
        'notes'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'float',
        'notes'  => 'string'
    ];

    /**
     * The objects that should be append to toArray.
     *
     * @var array
     */
    protected $with = [
        'myCar',
        'tradeAgainst'
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
        'myCar',
        'amount',
        'notes',
        'tradeAgainst'
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'owner_car_id'    => 'required',
        'customer_car_id' => 'required',
        'user_id'         => 'required',
        'amount'          => 'required',
        'notes'           => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'owner_car_id'    => 'required',
        'customer_car_id' => 'required',
        'user_id'         => 'required',
        'amount'          => 'required',
        'notes'           => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'owner_car_id'    => 'required|exists:cars,id',
        'customer_car_id' => 'required|exists:cars,id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function myCar()
    {
        return $this->belongsTo(MyCar::class, 'owner_car_id'); //showroom owner's car
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tradeAgainst()
    {
        return $this->belongsTo(MyCar::class, 'customer_car_id'); //app user's car
    }
}
