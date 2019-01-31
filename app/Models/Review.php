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
 * @property User review_by
 * @property MyCar review_on
 * @property ReviewDetail details
 *
 * @SWG\Definition(
 *     definition="rating",
 *     @SWG\Property(
 *          property="Id",
 *          description="Aspect Id",
 *          type="float",
 *          default="0.0"
 *     )
 * )
 *
 * @SWG\Definition(
 *      definition="Review",
 *      required={"car_id", "rating", "review_message"},
 *      @SWG\Property(
 *          property="car_id",
 *          description="car_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="rating",
 *          description="rating aspects id  : rate",
 *          type="array",
 *          @SWG\Items(ref="#/definitions/rating")
 *      ),
 *      @SWG\Property(
 *          property="review_message",
 *          description="review_message",
 *          type="string"
 *      )
 * )
 */
class Review extends Model
{
    use SoftDeletes;

    public $table = 'reviews';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'user_id',
        'car_id',
        'average_rating',
        'review_message'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'average_rating' => 'float',
        'review_message' => 'string'
    ];

    /**
     * The objects that should be append to toArray.
     *
     * @var array
     */
    protected $with = [
        'details'
    ];

    /**
     * The attributes that should be append to toArray.
     *
     * @var array
     */
    protected $appends = [
        'user_details'
    ];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'average_rating',
        'review_message',
        'user_details',
        'details'
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'car_id'         => 'required|exists:cars,id',
        'average_rating' => 'required',
        'review_message' => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'car_id'         => 'required|exists:cars,id',
        'average_rating' => 'required',
        'review_message' => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'car_id' => 'required|exists:cars,id',
        'rating' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reviewBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reviewOn()
    {
        return $this->belongsTo(MyCar::class, 'car_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany(ReviewDetail::class);
    }

    /**
     * @return array
     */
    public function getUserDetailsAttribute()
    {
        return [
            'user_id' => $this->reviewBy->id,
            'user_name' => $this->reviewBy->name,
            'image_url' => $this->reviewBy->details->image_url,
        ];
    }
}