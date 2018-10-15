<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserShowroom
 * @package App\Models
 *
 * @property integer id
 * @property integer user_id
 * @property string name
 * @property string last_name
 * @property string country_code
 * @property string phone
 * @property string address
 * @property integer email
 * @property integer about
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property User user
 * @property Media media
 *
 * )
 */
class UserShowroom extends Model
{
    use SoftDeletes;
    public $table = 'showroom_details';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'address', 'phone', 'email', 'about'];

    public static $rules = [];

    /**
     * The objects that should be append to toArray.
     *
     * @var array
     */
    protected $with = [
        'media'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id'      => 'int',
        'name'         => 'string',
        'country_code' => 'string',
        'phone'        => 'string',
        'address'      => 'string',
        'email'        => 'string',
        'about'        => 'string',
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
        'name',
        'country_code',
        'phone',
        'address',
        'email',
        'media',
        'about'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
        return 'showroom';
    }
}