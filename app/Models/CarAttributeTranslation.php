<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property integer attribute_id
 * @property string locale
 * @property string name
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 */
class CarAttributeTranslation extends Model
{
    use SoftDeletes;

    public $table = 'attribute_translations';

    public $fillable = [
        'attribute_id',
        'locale',
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
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
    protected $visible = [
    ];

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
