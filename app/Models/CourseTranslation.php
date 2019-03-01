<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CourseTranslation
 * @package App\Models
 *
 * @property integer id
 * @property integer course_id
 * @property string locale
 * @property string title
 * @property string subtitle
 * @property string description
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 */
class CourseTranslation extends Model
{
    use SoftDeletes;

    public $table = 'course_translations';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'course_id',
        'locale',
        'title',
        'subtitle',
        'about',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'course_id' => 'int'
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
        'locale'    => 'required',
        'course_id' => 'required',
        'title'     => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'locale'    => 'required',
        'course_id' => 'required'
    ];
}
