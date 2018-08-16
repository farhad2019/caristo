<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
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
 * )
 */
class News extends Model
{
    use SoftDeletes;
    use Translatable;

    public $table = 'news';

    public $translatedAttributes = ['headline', 'description', 'source'];

    protected $dates = ['deleted_at'];


    public $fillable = [
        'id',
        'category_id',
        'is_featured'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    /**
     * The objects that should be append to toArray.
     *
     * @var array
     */
    protected $with = [
        'media'
    ];

    /**
     * The attributes that should be append to toArray.
     *
     * @var array
     */
    protected $appends = [
        'is_liked',
        'is_favorite',
//        'is_favorite'
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
        'like_id',
        'comments_count',
        'is_featured',
        'created_at',
        'updated_at',
        'is_liked',
        'is_favorite',
        'media',
//        'deleted_at'
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'id'          => 'required',
        'category_id' => 'required',
        'is_featured' => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'id'          => 'required',
        'category_id' => 'required',
        'is_featured' => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'id'          => 'required',
        'category_id' => 'required',
        'is_featured' => 'required'
    ];

    public function Variants()
    {
        return $this->hasMany(\App\Models\ItemVariant::class, 'item_id', 'id');
    }

    public function Media()
    {
        return $this->morphMany(Media::class, 'instance');
    }

    public function getMorphClass()
    {
        return 'news';
    }

    public function getIsLikedAttribute()
    {
        return 0;
    }

    public function getIsFavoriteAttribute()
    {
        return 0;
    }

}