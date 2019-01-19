<?php

namespace App\Models;

use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Zizaco\Entrust\Traits\EntrustUserTrait;

/**
 * @property integer id
 * @property string name
 * @property string email
 * @property string password
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property string roles_csv
 *
 * @property Role roles
 * @property UserDetail details
 * @property UserDevice devices
 * @property MyCar cars
 * @property Region regions
 * @property MakeBid bids
 * @property UserShowroom showroom_details
 * @property NotificationUser notifications
 * @property mixed cat_interactions
 *
 * @SWG\Definition(
 *     definition="UserRegions",
 *     required={"region_id"},
 *     @SWG\Property(
 *          property="region_id",
 *          description="Region id",
 *          type="array",
 *          @SWG\Items(type="integer")
 *     ),
 *     @SWG\Property(
 *          property="region_reminder",
 *          description="region reminder",
 *          type="integer",
 *          format="int32"
 *     )
 * )
 *
 * @SWG\Definition(
 *      definition="User",
 *      required={"name", "email", "password"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable, CascadeSoftDeletes;

    use SoftDeletes {
        restore as private restoreA;
    }
    use EntrustUserTrait {
        restore as private restoreB;
    }

    protected $cascadeDeletes = ['details', 'devices'];

    const SHOWROOM_OWNER = 10;
    const RANDOM_USER = 20;

    const OFFICIAL_DEALER = 10;
    const MARKET_DEALER = 20;

    public static $DEALER_TYPE = [
        self::OFFICIAL_DEALER => 'Official Dealer',
        self::MARKET_DEALER => 'Market Dealer'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static $rules = [
        'name' => 'required|max:20',
        'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
        'expiry_date' => 'required|date_format:Y-m-d|after:today',
        'limit_for_cars' => 'required',
        'limit_for_featured_cars' => 'required',
//        'email'                 => 'required|email',
//        'phone'                 => 'required|string|max:20',
//        'roles'                 => 'required',
        'dealer_type' => 'required|in:10,20',
        'password' => 'required|min:6|required_with:password_confirmation|same:password_confirmation',
        'password_confirmation' => 'min:6'
    ];

    public static $updateRules = [
        'name' => 'required|max:20',
        'email' => 'sometimes|required|email',
        'profession' => 'required',
        'dob' => 'required|date_format:Y-m-d|before:today',
        'country_code' => 'required|max:5',
        'phone' => 'phone|max:20',
        'roles' => 'sometimes|required',
        'image' => 'sometimes|required|image|mimes:jpg,jpeg,png|max:500',
//        'expiry_date' => 'required|date_format:Y-m-d|after:today',
//        'limit_for_cars' => 'required|gt:limit_for_featured_cars',
//        'limit_for_featured_cars' => 'required',
        'password' => 'sometimes|nullable|min:6|required_with:password_confirmation|same:password_confirmation',
        'password_confirmation' => 'sometimes|nullable|min:6',
    ];

    public static $updateShowroomProfileRules = [
        'name' => 'required|max:30',
        'profession' => 'required',
        'dob' => 'required|date_format:Y-m-d|before:today',
//        'email'                 => 'required|email',
        'phone' => 'required|phone|max:25',
        'password' => 'sometimes|nullable|min:6|required_with:password_confirmation|same:password_confirmation',
        'password_confirmation' => 'sometimes|nullable|min:6',
        'address' => 'sometimes|nullable|max:70',
//        'about'                 => 'sometimes|nullable|max:70',
        'showroom_name' => 'required|max:30',
        'showroom_email' => 'required|email',
        'showroom_phone' => 'required|phone|max:25',
        'showroom_media' => 'image|mimes:jpg,jpeg,png',
        'showroom_address' => 'sometimes|nullable|max:70',
        'showroom_about' => 'sometimes|nullable|max:70',

    ];

    /**
     * The objects that should be append to toArray.
     *
     * @var array
     */
    protected $with = [
        'details',
        'showroomDetails',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'email' => 'string',
    ];

    /**
     * The attributes that should be append to toArray.
     *
     * @var array
     */
    protected $appends = [
        'push_notification',
        'cars_count',
        'favorite_count',
        'like_count',
        'view_count'
    ];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'name',
        'email',
        'details',
        'showroomDetails',
        'cars_count',
        'favorite_count',
        'like_count',
        'view_count',
        'created_at',
        'push_notification',

    ];

    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }

    /**
     * @return string
     */
    public function getRolesCsvAttribute()
    {
        return implode(",", $this->roles->pluck('display_name')->all());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function details()
    {
        return $this->hasOne(UserDetail::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function devices()
    {
        return $this->hasMany(UserDevice::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function newsInteractions()
    {
        return $this->hasMany(NewsInteraction::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasManyThrough
     */
    public function favorites()
    {
        return $this->hasManyThrough(News::class, NewsInteraction::class, 'user_id', 'id', 'id', 'news_id')->where(['news_interactions.type' => NewsInteraction::TYPE_FAVORITE]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasManyThrough
     */
    public function favoriteCars()
    {
        return $this->hasManyThrough(MyCar::class, CarInteraction::class, 'user_id', 'id', 'id', 'car_id')->where(['car_interactions.type' => CarInteraction::TYPE_FAVORITE]);
    }

    public function likeCars()
    {
        return $this->hasManyThrough(MyCar::class, CarInteraction::class, 'user_id', 'id', 'id', 'car_id')->where(['car_interactions.type' => CarInteraction::TYPE_LIKE]);
    }

    public function viewCars()
    {
        return $this->hasManyThrough(MyCar::class, CarInteraction::class, 'user_id', 'id', 'id', 'car_id')->where(['car_interactions.type' => CarInteraction::TYPE_VIEW]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function catInteractions()
    {
        return $this->hasMany(CarInteraction::class, 'user_id');
        //return $this->hasManyThrough(MyCar::class, CarInteraction::class, 'user_id', 'id', 'id', 'car_id')->where(['car_interactions.type' => CarInteraction::TYPE_FAVORITE]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cars()
    {
        return $this->hasMany(MyCar::class, 'owner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function regions()
    {
        return $this->belongsToMany(Region::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
//    public function bids()
//    {
//        return $this->hasMany(MakeBid::class);
//    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function showroomDetails()
    {
        return $this->hasOne(UserShowroom::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function notifications()
    {
        return $this->hasMany(NotificationUser::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function notificationMaster()
    {
        return $this->belongsToMany(Notification::class, 'notification_users')->withPivot('status');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    /**
     * @return int
     */
    public function getPushNotificationAttribute()
    {
        return $this->devices->first()->push_notification ?? 0;
    }

    public function getCarsCountAttribute()
    {
        return $this->cars()->count();
    }

    public function getFavoriteCountAttribute()
    {
        return $this->favoriteCars()->count();
    }

    public function getLikeCountAttribute()
    {
        return $this->likeCars()->count();
    }

    public function getViewCountAttribute()
    {
        return $this->viewCars()->count();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'user_id');
    }

    public function commentswithtrash()
    {
        return $this->hasMany(Comment::class, 'user_id')->withTrashed();
    }

    public function detailswithtrash()
    {
        return $this->hasOne(UserDetail::class)->withTrashed();
    }

}