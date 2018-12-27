<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property integer user_id
 * @property integer parent_id
 * @property string name
 * @property string slug
 * @property integer type
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property Media media
 * @property News news
 * @property CarInteraction car_interaction
 *
 * @property string parent_category
 * @property string child_category
 * @property string unread_count
 * @property string type_text
 * @property mixed clicks_count
 *
 * @SWG\Definition(
 *      definition="Category",
 *      required={"slug"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="slug",
 *          description="slug",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="user_id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class Category extends Model
{
    use SoftDeletes, CascadeSoftDeletes, Translatable;

    public $table = 'category';
    protected $cascadeDeletes = ['media', 'news'];
    public $translatedAttributes = ['name', 'subtitle', 'description'];
    protected $dates = ['deleted_at'];

    const NEWS = 10;
    const COMPARE = 20;
    const LUX_MARKET = 30;

    public static $TYPE_TEXT = [
        self::NEWS       => 'News',
        self::COMPARE    => 'Comparision',
        self::LUX_MARKET => 'Luxury Market'
    ];

    public $fillable = [
        'name',
        'slug',
        'user_id',
        'parent_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'slug'      => 'string',
        'user_id'   => 'int',
        'parent_id' => 'int'
    ];

    /**
     * The objects that should be append to toArray.
     *
     * @var array
     */
    protected $with = [
//        'parentCategory',
        'media',
        'childCategory',
    ];

    /**
     * The attributes that should be append to toArray.
     *
     * @var array
     */
    protected $appends = [
        'unread_count',
        'clicks_count',
//        'type_text'
    ];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'name',
        'user_id',
        'slug',
        'type',
        'type_text',
        'description',
        'created_at',
        'updated_at',
//        'parentCategory',
        'media',
        'childCategory',
        'clicks_count',
//        'deleted_at'
//        'unread_count'
    ];

    /**
     * @var array
     */
    protected $hidden = ['unread_count'];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'name'  => 'required',
        'media' => 'required|image|mimes:jpg,jpeg,png',
        'slug'  => 'required',
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'name'  => 'required',
        'media' => 'sometimes|image|mimes:jpg,jpeg,png',
        'slug'  => 'required',
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'slug' => 'required'
    ];

//    public function Subcategories()
//    {
//        return $this->hasMany(\App\Models\Subcategories::class, 'item_id', 'id');
//    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function media()
    {
        return $this->morphMany(Media::class, 'instance');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cars()
    {
        return $this->hasMany(MyCar::class, 'category_id');
    }

    /**
     * @return string
     */
    public function getMorphClass()
    {
        return 'category';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childCategory()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function news()
    {
        return $this->hasMany(News::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function carInteraction()
    {
        return $this->hasMany(CarInteraction::class, 'car_id');
    }

    /**
     * @return mixed
     */
    public function getClicksCountAttribute()
    {
        return $this->carInteraction->count();
    }

    /**
     * @return int
     */
    public function getUnreadCountAttribute()
    {
        // FIXME: Find a better way.
        $unread = $this->news()->whereDoesntHave('views', function ($query) {
            return $query->where('user_id', \Auth::id());
        })->count();

        // FIXME: Find a better way.
        foreach ($this->childCategory as $child) {
            $unread += $child->unread_count;
        }

        return $unread;
    }

    /**
     * @return mixed
     */
    public function getTypeTextAttribute()
    {
        return self::$TYPE_TEXT[$this->type];
    }
}