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
 *      definition="Course",
 *      required={"category_id", "latitude", "longitude", "location", "language", "duration", "date", "time", "price", "currency", "intro_link"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="category_id",
 *          description="category_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="latitude",
 *          description="latitude",
 *          type="number",
 *          format="float"
 *      ),
 *      @SWG\Property(
 *          property="longitude",
 *          description="longitude",
 *          type="number",
 *          format="float"
 *      ),
 *      @SWG\Property(
 *          property="location",
 *          description="location",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="language",
 *          description="language",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="duration",
 *          description="duration",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="date",
 *          description="date",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="price",
 *          description="price",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="currency",
 *          description="currency",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="intro_link",
 *          description="intro_link",
 *          type="string"
 *      )
 * )
 */
class Course extends Model
{
    use SoftDeletes, Translatable;

    public $table = 'courses';
    public $translatedAttributes = ['title', 'subtitle', 'description', 'about'];
    protected $dates = ['deleted_at'];

    const INSTANCE = 'category';

    public $fillable = [
        'category_id',
        'latitude',
        'longitude',
        'location',
        'language',
        'duration',
        'date',
        'time',
        'price',
        'currency',
        'intro_link'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'latitude'   => 'float',
        'longitude'  => 'float',
        'location'   => 'string',
        'language'   => 'string',
        'duration'   => 'string',
        'intro_link' => 'string'
    ];

    /**
     * The objects that should be append to toArray.
     *
     * @var array
     */
    protected $with = [
        'media',
        'category',
        'chapters'
    ];

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
        'title',
        'description',
        'about',
        'subtitle',
        'latitude',
        'longitude',
        'location',
        'language',
        'duration',
        'date',
        'time',
        'price',
        'currency',
        'intro_link',
        'created_at',
        'media',
        'category',
        'chapters'
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'category_id' => 'required',
        'language'    => 'required',
        'price'       => 'required',
//        'intro_link'  => 'sometimes|required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'category_id' => 'required',
        'language'    => 'required',
        'price'       => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'category_id' => 'required',
        'latitude'    => 'required',
        'longitude'   => 'required',
        'location'    => 'required',
        'language'    => 'required',
        'duration'    => 'required',
        'date'        => 'required',
        'time'        => 'required',
        'price'       => 'required',
        'currency'    => 'required',
        'intro_link'  => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'course_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function media()
    {
        return $this->morphMany(Media::class, 'instance');
    }

    /**
     * @return string
     */
    public function getMorphClass()
    {
        return self::INSTANCE;
    }
}
