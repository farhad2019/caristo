<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CarBrandTranslation
 * @package App\Models
 *
 * @property integer id
 * @property integer brand_id
 * @property string locale
 * @property string name
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property CarBrand brand
 */
class CarBrandTranslation extends Model
{
    use SoftDeletes;

    public $table = 'brand_translations';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'brand_id',
        'locale',
        'name'
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
        'name' => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'name' => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'name' => 'required'
    ];
}