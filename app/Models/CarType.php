<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property integer parent_id
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property string image
 *
 * @property MyCar cars
 * @property Media media
 * @property CarType parent_category
 *
 * @property mixed|null selected_icon
 * @property mixed|null un_selected_icon
 *
 * @SWG\Definition(
 *      definition="CarType",
 *      required={"id"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class CarType extends Model
{
    use SoftDeletes, Translatable;

    public $table = 'car_types';

    protected $dates = ['deleted_at'];
    protected $translatedAttributes = ['name'];
    protected $translationForeignKey = 'car_type_id';

    public $fillable = [
        'id',
        'parent_id'
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
    protected $with = [];

    /**
     * The attributes that should be append to toArray.
     *
     * @var array
     */
    protected $appends = [
        'image',
        'selected_icon',
        'un_selected_icon'
    ];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'name',
        'image',
        'selected_icon',
        'un_selected_icon'
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'name'    => 'required|max:50',
        'image'   => 'required',
        'image.*' => 'image|mimes:jpg,jpeg,png|max:500',
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'name' => 'required|max:50'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'name' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cars()
    {
        return $this->hasMany(MyCar::class, 'type_id');
    }

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
    public function childCategory()
    {
        return $this->hasMany(CarType::class, 'parent_id', 'id')->orderBy('created_at', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentCategory()
    {
        return $this->belongsTo(CarType::class, 'parent_id', 'id');
    }

    /**
     * @return string
     */
    public function getMorphClass()
    {
        return 'carType';
    }

    /**
     * @return mixed|null
     */
    public function getImageAttribute()
    {
        return !empty($this->media()->where('title', 'selected')->first()) ? $this->media()->where('title', 'selected')->first()->file_url : null;
    }

    /**
     * @return mixed|null
     */
    public function getSelectedIconAttribute()
    {
        return !empty($this->media()->where('title', 'selected')->first()) ? $this->media()->where('title', 'selected')->first()->file_url : null;
    }

    /**
     * @return mixed|null
     */
    public function getUnSelectedIconAttribute()
    {
        return !empty($this->media()->where('title', 'un_selected')->first()) ? $this->media()->where('title', 'un_selected')->first()->file_url : null;
    }
}