<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CategoryTranslation
 * @package App\Models
 *
 * @property integer id
 * @property integer category_id
 * @property string locale
 * @property string name
 * @property integer status
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property Page page
 */
class CategoryTranslation extends Model
{
    use SoftDeletes;

    public $table = 'category_translations';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'category_id',
        'locale',
        'name',
        'subtitle',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'locale' => 'string',
        'name'   => 'string',
        'status' => 'boolean'
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
        'locale'      => 'required',
        'category_id' => 'required',
        'name'        => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'locale'      => 'required',
        'category_id' => 'required'
    ];
}
