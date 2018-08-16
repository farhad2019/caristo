<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @property integer id
 * @property integer user_id
 * @property string first_name
 * @property string last_name
 * @property string phone
 * @property string address
 * @property string image
 * @property integer area_id
 * @property integer email_updates
 * @property integer social_login
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property User user
 *
 * )
 */
class UserDetail extends Model
{
    use SoftDeletes;
    public $table = 'user_details';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'phone', 'address', 'image', 'area_id', 'email_updates', 'social_login', 'about'
    ];

    public static $rules = [];

    /**
     * The objects that should be append to toArray.
     *
     * @var array
     */
    protected $with = [
    ];

    /**
     * The attributes that should be append to toArray.
     *
     * @var array
     */
    protected $appends = [
        'image_url',
        //'area'
    ];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'first_name',
        'last_name',
        'phone',
        'address',
        'image',
        'image_url',
        'area_id',
        'email_updates',
        'social_login',
        'about'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute()
    {
        return ($this->image) ? route('api.resize', ['img' => $this->image]) : route('api.resize', ['img' => 'users/user.png']);
    }
}
