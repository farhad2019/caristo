<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * @property integer id
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property string is_my_region
 * @property string flag
 *
 * @property User user
 * @property Media media
 * @property CarRegion car_region
 *
 * @SWG\Definition(
 *      definition="Region",
 *      required={"id", "name"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      )
 * )
 */
class Region extends Model
{
    use SoftDeletes;

    public $table = 'regions';
    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
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
        'is_my_region',
        'flag'
    ];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'name',
        'flag',
        'is_my_region'
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'flag'   => 'required|image|mimes:jpg,jpeg,png'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'name' => 'required',
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'name' => 'required',
        'flag' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user()
    {
        return $this->belongsToMany(User::class);
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
        return 'region';
    }

    public function getIsMyRegionAttribute()
    {
        return ($this->user()->where('id', Auth::id())->count() > 0) ? 1 : 0;
    }

    /**
     * @return mixed|null
     */
    public function getFlagAttribute()
    {
        return $this->media()->first() ? $this->media()->first()->file_url : null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function car_region()
    {
        return $this->hasMany(CarRegion::class, 'region_id');
    }
}
