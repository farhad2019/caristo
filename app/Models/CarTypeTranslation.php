<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property integer car_type_id
 * @property string locale
 * @property string name
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 */
class CarTypeTranslation extends Model
{
    use SoftDeletes;

    public $table = 'car_type_translations';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'name',
        'locale',
        'car_type_id',
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
