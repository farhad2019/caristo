<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @SWG\Definition(
 *      definition="Chapter",
 *      required={"course_id", "link"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="course_id",
 *          description="course_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="link",
 *          description="link",
 *          type="string"
 *      )
 * )
 */
class Chapter extends Model
{
    use SoftDeletes, Translatable;

    public $table = 'chapters';
    public $translatedAttributes = ['title', 'subtitle', 'description'];

    protected $dates = ['deleted_at'];

    public $fillable = [
        'course_id',
        'link'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'link' => 'string'
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
        'id',
        'link',
        'created_at',
        'title',
        'subtitle',
        'description',
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'course_id' => 'required',
        'link'      => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'course_id' => 'required',
        'link'      => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'course_id' => 'required',
        'link'      => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
