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
 * @property string icon
 *
 * @property MyCar cars
 * @property Media media
 *
 * @SWG\Definition(
 *      definition="CarFeature",
 *      required={"id", "updated_at"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class CarFeature extends Model
{
    use SoftDeletes, Translatable;

    public $table = 'features';

    protected $dates = ['deleted_at'];
    protected $translatedAttributes = ['name'];
    protected $translationForeignKey = 'feature_id';


    public $fillable = [
        'name'
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
        'icon'
    ];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'icon',
        'name'
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:50',
        'icon'   => 'required|image|mimes:jpg,jpeg,png'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'name' => 'required|max:50',
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
    ];

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
        return 'carFeature';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cars()
    {
        return $this->belongsToMany(MyCar::class, 'car_features', 'car_id', 'feature_id', 'id', 'id');
    }

    /**
     * @return mixed|null
     */
    public function getIconAttribute()
    {
        return !empty($this->media()->first()) ? $this->media()->first()->file_url : null;
    }
}
