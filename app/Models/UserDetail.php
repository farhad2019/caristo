<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @property integer id
 * @property integer user_id
 * @property string first_name
 * @property string last_name
 * @property string country_code
 * @property string phone
 * @property string address
 * @property string image
 * @property integer area_id
 * @property integer email_updates
 * @property integer social_login
 * @property integer region_reminder
 * @property integer is_verified
 * @property int gender
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property User user
 *
 * @property string image_url
 * @property mixed gender_label
 *
 * )
 */
class UserDetail extends Model
{
    use SoftDeletes;
    public $table = 'user_details';

    const MALE = 10;
    const FEMALE = 20;

    public static $GENDER = [
        0            => 'Select Gender',
        self::MALE   => 'Male',
        self::FEMALE => 'Female'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'dealer_type', 'country_code', 'phone', 'address', 'image', 'area_id', 'email_updates', 'social_login', 'about', 'region_reminder', 'region_id', 'limit_for_cars', 'limit_for_featured_cars', 'expiry_date',  'dob', 'profession', 'nationality', 'gender', 'dealer_type_text'
    ];

    public static $rules = [];

    /**
     * The objects that should be append to toArray.
     *
     * @var array
     */
    protected $with = [
        'regionDetail'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id'       => 'int',
        'first_name'    => 'string',
        'last_name'     => 'string',
        'country_code'  => 'string',
        'phone'         => 'string',
        'address'       => 'string',
        'image'         => 'string',
        'dob'           => 'string',
        'expiry_date'   => 'string',
        'profession'    => 'string',
        'nationality'   => 'string',
        'gender'        => 'int',
        'email_updates' => 'boolean',
        'social_login'  => 'boolean',
    ];

    /**
     * The attributes that should be append to toArray.
     *
     * @var array
     */
    protected $appends = [
        'image_url',
        'gender_label',
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
        'country_code',
        'dealer_type',
        'dealer_type_text',
        'phone',
        'address',
        'image',
        'image_url',
        'area_id',
        'dob',
        'is_verified',
        'profession',
        'nationality',
        'gender',
        'region_id',
        'limit_for_cars',
        'limit_for_featured_cars',
        'expiry_date',
        'gender_label',
        'email_updates',
        'social_login',
        'region_reminder',
        'about',
        'regionDetail'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function regionDetail()
    {
        return $this->hasOne(Region::class,'id','region_id');
    }

    /**
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return ($this->image && file_exists(storage_path('app/' . $this->image))) ? route('api.resize', ['img' => $this->image]) : route('api.resize', ['img' => 'public/user.png', 'w=50', 'h=50']);
    }

    /**
     * @return mixed
     */
    public function getGenderLabelAttribute()
    {
        return self::$GENDER[$this->gender];
    }
}