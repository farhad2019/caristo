<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property integer user_id
 * @property string platform
 * @property string client_id
 * @property string token
 * @property string username
 * @property string email
 * @property string expires_at
 *
 * @SWG\Definition(
 *      definition="SocialAccounts",
 *      required={"platform", "client_id"},
 *      @SWG\Property(
 *          property="platform",
 *          description="platform",
 *          type="string"
 *      ), @SWG\Property(
 *          property="client_id",
 *          description="client_id",
 *          type="string"
 *      ), @SWG\Property(
 *          property="token",
 *          description="token",
 *          type="string",
 *      ), @SWG\Property(
 *          property="username",
 *          description="username",
 *          type="string",
 *      ), @SWG\Property(
 *          property="email",
 *          description="email",
 *          type="string",
 *      ),@SWG\Property(
 *          property="image",
 *          description="image",
 *          type="string",
 *      ),@SWG\Property(
 *          property="device_token",
 *          description="User Device Token",
 *          type="string"
 *      ),@SWG\Property(
 *          property="device_type",
 *          description="User Device Type",
 *          type="string"
 *      ), @SWG\Property(
 *          property="expires_at",
 *          description="expires_at",
 *          type="string",
 *      )
 * )
 */
class SocialAccount extends Model
{
    use SoftDeletes;
    public $table = 'social_accounts';

//    protected $primaryKey = [
//        'property_id',
//        'user_id'
//    ];

    protected $dates = ['deleted_at'];

    public $fillable = [
        'user_id',
        'platform',
        'client_id',
        'token',
        'username',
        'email',
        'expires_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id'   => 'int',
        'platform'  => 'string',
        'client_id' => 'string',
        'token'     => 'string',
        'email'     => 'string',
        'username'  => 'string',
    ];

//    protected $visible = [
//        'property_id',
//        'user_id'
//    ];
//
//    protected $with = [
//        'user'
//    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'platform'    => 'required',
//        'device_token' => 'required',
        'device_type' => 'required',
        'client_id'   => 'required',
//        'token'        => 'required',
//        'email'       => 'sometimes|required|email',
        'email'                 => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
