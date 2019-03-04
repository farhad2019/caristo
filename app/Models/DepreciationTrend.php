<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class DepreciationTrend
 * @package App\Models
 */
class DepreciationTrend extends Model
{
    use SoftDeletes;

    public $table = 'car_depreciation_trends';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'car_id',
        'year_title',
        'year',
        'percentage',
        'amount'
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
    protected $visible = [
        'year',
        'year_title',
        'percentage',
        'amount'
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'year'       => 'required',
        'percentage' => 'required',
        'amount'     => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'year'       => 'required',
        'percentage' => 'required',
        'amount'     => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'year'       => 'required',
        'percentage' => 'required',
        'amount'     => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cars()
    {
        return $this->belongsTo(MyCar::class, 'car_id');
    }
}