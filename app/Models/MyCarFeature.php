<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer car_id
 * @property integer feature_id
 *
 *
 * @property CarAttribute car_attribute
 * @property MyCar myCar
 *
 */
class MyCarFeature extends Model
{
    public $table = 'car_features';

    public $fillable = [
        'car_id',
        'feature_id'
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
    protected $with = [
        'carFeature'
    ];

    /**
     * The attributes that should be append to toArray.
     *
     * @var array
     */
    protected $appends = [
        'id',
        'icon',
        'name'
    ];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'icon',
        'name'
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function carFeature()
    {
        return $this->belongsTo(CarFeature::class, 'feature_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function myCar()
    {
        return $this->belongsTo(MyCar::class, 'car_id');
    }

    public function getIdAttribute()
    {
        return $this->carFeature->id;
    }

    public function getIconAttribute()
    {
        return $this->carFeature->icon;
    }

    public function getNameAttribute()
    {
        return $this->carFeature->name;
    }
}