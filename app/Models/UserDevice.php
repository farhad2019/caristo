<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @property integer id
 * @property integer user_id
 * @property string device_type
 * @property string device_token
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property User user
 *
 * )
 */
class UserDevice extends Model
{
    use SoftDeletes;
    public $table = 'user_devices';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'device_type', 'device_token'
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

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id'      => 'int',
        'device_type'  => 'string',
        'device_token' => 'string',
    ];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
