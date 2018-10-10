<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AttributeOptionTranslation
 * @package App\Models
 *
 * @property integer id
 * @property integer attribute_option_id
 * @property string locale
 * @property string option
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 */
class AttributeOptionTranslation extends Model
{
    use SoftDeletes;

    public $table = 'attribute_option_translations';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'locale',
        'attribute_option_id',
        'option'
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
    public static $rules = [];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [];

    /**
     * Validation api rules
     * @var array
     */
    public static $api_rules = [];
}
