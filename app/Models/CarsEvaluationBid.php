<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property integer evaluation_id
 * @property integer user_id
 * @property float amount
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @SWG\Definition(
 *      definition="CarsEvaluation",
 *      required={"evaluation_id", "user_id", "amount"},
 *      @SWG\Property(
 *          property="evaluation_id",
 *          description="evaluation_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="amount",
 *          description="amount",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="car_id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class CarsEvaluationBid extends Model
{
    use SoftDeletes;

    public $table = 'car_evaluation_bids';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'evaluation_id',
        'user_id',
        'amount',
        'status'
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
        'evaluation_id' => 'required|exists:car_evaluations,id',
        'amount' => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'evaluation_id' => 'required|exists:car_evaluations,id',
        'amount' => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'evaluation_id' => 'required|exists:car_evaluations,id',
        'amount' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bids()
    {
        return $this->belongsTo(CarsEvaluation::class, 'evaluation_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
