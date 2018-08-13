<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class NewsTranslation
 * @package App\Models
 *
 * @property integer id
 * @property integer news_id
 * @property string headline
 * @property string description
 * @property string source
 * @property string locale
 * @property integer status
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property Page page
 */
class NewsTranslation extends Model
{
    use SoftDeletes;

    public $table = 'news_translations';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'news_id',
        'headline',
        'description',
        'source',
        'locale',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'locale'      => 'string',
        'headline'    => 'string',
        'name'        => 'string',
        'description' => 'string',
        'source'      => 'string',
        'status'      => 'boolean'
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
        'headline'    => 'required',
        'name'        => 'required',
        'description' => 'required',
        'source'      => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'news_id'     => 'required',
        'locale'      => 'required',
        'headline'    => 'required',
        'name'        => 'required',
        'description' => 'required',
        'source'      => 'required'
    ];
}
