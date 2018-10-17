<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer car_id
 * @property integer attribute_id
 * @property string value
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property string option_array
 *
 * @property CarAttribute car_attribute
 * @property MyCar myCar
 *
 */
class MyCarAttribute extends Model
{
    use SoftDeletes;

    public $table = 'car_attributes';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'car_id',
        'attribute_id'
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
    protected $appends = [
        'attr_id',
        'attr_name'
//        'option_array'
    ];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [
        'attr_id',
        'attr_name',
        'value'
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
    public function carAttribute()
    {
        return $this->belongsTo(CarAttribute::class, 'attribute_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function myCar()
    {
        return $this->belongsTo(MyCar::class, 'car_id');
    }

    /**
     * @return mixed
     */
    public function getAttrNameAttribute()
    {
        return $this->carAttribute->name;
    }

    /**
     * @return mixed
     */
    public function getAttrIdAttribute()
    {
        return $this->carAttribute->id;
    }
}