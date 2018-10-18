<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property integer car_id
 * @property string country_code
 * @property integer phone
 * @property string name
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @SWG\Definition(
 *      definition="ContactUs",
 *      required={"car_id", "name", "email", "subject", "message"},
 *      @SWG\Property(
 *          property="car_id",
 *          description="car id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="email",
 *          description="email",
 *          type="email"
 *      ),
 *      @SWG\Property(
 *          property="country_code",
 *          description="country code",
 *          default="+971",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="phone",
 *          description="phone",
 *          default="1234567",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class ContactUs extends Model
{
    use SoftDeletes;

    public $table = 'admin_queries';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'car_id',
        'user_id',
        'name',
        'email',
        'country_code',
        'phone'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        /*'name'    => 'string',
        'email'   => 'string',
        'subject' => 'string',
        'message' => 'string',
        'status'  => 'boolean'*/
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
    protected $appends = [];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'name'    => 'required',
        'email'   => 'required|email',
        'subject' => 'required',
        'message' => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'name'    => 'required',
        'email'   => 'required|email',
        'subject' => 'required',
        'message' => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'car_id'       => 'required|exists:cars,id',
        'name'         => 'required',
        'email'        => 'required|email',
        'country_code' => 'required',
        'phone'        => 'required'
    ];


}
