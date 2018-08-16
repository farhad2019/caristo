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
 * @property Role Role
 * @property UserDetail details
 * @property UserDevice devices
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

    public static $rules = [];

    /**
     * The objects that should be append to toArray.
     *
     * @var array
     */
    protected $with = [
        'details'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name'  => 'string',
        'email' => 'string',
    ];

    /**
     * The attributes that should be append to toArray.
     *
     * @var array
     */
    protected $appends = [

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
        'created_at',
    ];

    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }

    public function getRolesCsvAttribute()
    {
        return implode(",", $this->roles->pluck('display_name')->all());
    }

    public function Roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    public function details()
    {
        return $this->hasOne(UserDetail::class);
    }

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

    public function devices()
    {
        return $this->hasMany(UserDevice::class);
    }
}
