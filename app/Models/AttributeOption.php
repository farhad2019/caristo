<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property string option
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 */
class AttributeOption extends Model
{
    use SoftDeletes, Translatable;

    public $table = 'attribute_options';
    protected $dates = ['deleted_at'];
    protected $translatedAttributes = ['option'];
    protected $translationForeignKey = 'attribute_option_id';

    public $fillable = [];

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
        'option_array'
    ];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [
//        'id',
//        'attribute_id',
//        'option',
        'option_array'
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

    public function getOptionArrayAttribute()
    {
        return [$this->id => $this->option];
    }
}