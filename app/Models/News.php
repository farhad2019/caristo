<?php

namespace App\Models;

use App\Helper\Utils;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 * @property int id
 * @property string link
 *
 * @SWG\Definition(
 *      definition="News",
 *      required={"id", "category_id", "is_featured"},
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
 *          property="user_id",
 *          description="user_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="views_count",
 *          description="views_count",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="favorite_count",
 *          description="favorite_count",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="like_count",
 *          description="like_count",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="comments_count",
 *          description="comments_count",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="is_featured",
 *          description="is_featured",
 *          type="integer",
 *          format="int32"
 *      )
 *
 * )
 */
class News extends Model
{
    use SoftDeletes, Translatable;

    public $table = 'news';
    public $translatedAttributes = ['headline', 'description', 'source'];
    protected $dates = ['deleted_at'];

    const INSTANCE = 'news';

    const TYPE_IMAGE = 10;
    const TYPE_VIDEO = 20;

    public static $MEDIA_TYPE = [
        self::TYPE_IMAGE => 'Image',
        self::TYPE_VIDEO => 'Video'
    ];

    public $fillable = [
        'id',
        'category_id',
        'is_featured',
        'source_image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'category_id'    => 'integer',
        'user_id'        => 'int',
        'views_count'    => 'int',
        'favorite_count' => 'int',
        'like_count'     => 'int',
        'comments_count' => 'int',
        'is_featured'    => 'int',
        'is_liked'       => 'boolean',
        'is_viewed'      => 'boolean',
        'is_favorite'    => 'boolean'

    ];

    /**
     * The default values that should be applied to attributes
     *
     * @var array
     */
    protected $attributes = [
        'views_count'    => 0,
        'favorite_count' => 0,
        'like_count'     => 0,
        'comments_count' => 0,
        'is_featured'    => 0
    ];

    /**
     * The objects that should be append to toArray.
     *
     * @var array
     */
    protected $with = [
        'media',
        'meta'
    ];

    /**
     * The attributes that should be append to toArray.
     *
     * @var array
     */
    protected $appends = [
        'link',
        'is_liked',
        'is_viewed',
        'is_favorite',
        'source_image_url'
    ];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'category_id',
        'user_id',
        'views_count',
        'favorite_count',
        'like_count',
        'comments_count',
        'is_featured',
        'created_at',
        'updated_at',
        'is_liked',
        'is_viewed',
        'is_favorite',
        'link',
        'media',
        'meta',
        'source_image_url',
//        'category'
//        'deleted_at'
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'category_id'  => 'required',
        'headline'     => 'required',
        'source'       => 'sometimes|nullable|url',
        'source_image' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,bmp|max:500',
//        'image'        => 'required_without:video_url|image|mimes:jpg,jpeg,png,bmp|max:5000',
//        'video_url'    => 'required_without:image|nullable|url',
        'is_featured'  => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
//        'id'          => 'required',
        'category_id' => 'required',
        'is_featured' => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
//        'id'          => 'required',
        'category_id' => 'required',
        'is_featured' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function views()
    {
        return $this->hasMany(NewsInteraction::class)->where('type', NewsInteraction::TYPE_VIEW);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(NewsInteraction::class)->where('type', NewsInteraction::TYPE_LIKE);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favorites()
    {
        return $this->hasMany(NewsInteraction::class)->where('type', NewsInteraction::TYPE_FAVORITE);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function media()
    {
        return $this->morphMany(Media::class, 'instance');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function meta()
    {
        return $this->morphMany(MetaInformation::class, 'instance');
    }

    /**
     * @return string
     */
    public function getMorphClass()
    {
        return self::INSTANCE;
    }

    /**
     * @return bool
     */
    public function getIsLikedAttribute()
    {
        return ($this->likes()->where('user_id', \Auth::id())->first() != null);
    }

    /**
     * @return bool
     */
    public function getIsFavoriteAttribute()
    {
        return ($this->favorites()->where('user_id', \Auth::id())->first() != null);
    }

    /**
     * @return bool
     */
    public function getIsViewedAttribute()
    {
        return ($this->views()->where('user_id', \Auth::id())->first() != null);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'news_id');
    }

    /**
     * @return string
     */
    public function getSourceImageUrlAttribute()
    {
        return ($this->source_image && file_exists(storage_path('app/' . $this->source_image))) ? route('api.resize', ['img' => $this->source_image]) : route('api.resize', ['img' => 'public/no_image.png', 'w=50', 'h=50']);

    }

    /**
     * @return string
     */
    public function getLinkAttribute()
    {
        return url('') . '?type=' . Utils::NEWS_DEEP_LINK . '&id=' . $this->id;
    }
}