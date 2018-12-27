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
 * @property string image
 *
 * @property MyCar cars
 * @property Media media
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
        'image'
    ];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'name',
        'image'
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:50',
        'image'   => 'required|image|mimes:jpg,jpeg,png'
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
        return !empty($this->media()->first()) ? $this->media()->first()->file_url : null;
    }
}