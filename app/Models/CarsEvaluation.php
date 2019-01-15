<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property integer car_id
 * @property string expired_at
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @SWG\Definition(
 *      definition="CarsEvaluation",
 *      required={"car_id"},
 *      @SWG\Property(
 *          property="car_id",
 *          description="car_id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class CarsEvaluation extends Model
{
    use SoftDeletes;

    public $table = 'car_evaluations';

    protected $dates = ['deleted_at'];

    /**
     * Sunday
     * Monday
     * Tuesday
     * Wednesday
     * Thursday
     * Friday
     * Saturday
     */
    const WEEK_END = ['Friday'];

    public $fillable = [
        'car_id',
        'expired_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

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
        'car_id' => 'required|exists:cars,id'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'car_id' => 'required|exists:cars,id'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'car_id' => 'required|exists:cars,id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bids()
    {
        return $this->belongsTo(CarEvaluationBid::class, 'evaluation_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function evaluationCar()
    {
        return $this->belongsTo(MyCar::class, 'car_id');
    }
}
