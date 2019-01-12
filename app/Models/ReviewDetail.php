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
 */
class ReviewDetail extends Model
{
    use SoftDeletes;

    public $table = 'review_details';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'review_id',
        'type_id',
        'rating'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'rating' => 'float'
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
        'car_id'         => 'required|exists:cars,id',
        'average_rating' => 'required',
        'review_message' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function review()
    {
        return $this->belongsTo(Review::class);
    }


}
