<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CarModelTranslation
 * @package App\Models
 *
 * @property integer id
 * @property integer brand_id
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 */
class CarModelTranslation extends Model
{
    use SoftDeletes;

    public $table = 'car_model_translations';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'locale',
        'car_model_id',
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

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
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
    ];
}