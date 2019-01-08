<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property integer sender_id
 * @property integer ref_id
 * @property integer action_type
 * @property string url
 * @property string message
 * @property integer status
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property string users_csv
 * @property integer delivery_status
 *
 * @SWG\Definition(
 *      definition="Notification",
 *      required={"sender_id", "url", "action_type", "ref_id", "message", "status"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="sender_id",
 *          description="sender_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="url",
 *          description="url",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="action_type",
 *          description="action_type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="ref_id",
 *          description="ref_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="message",
 *          description="message",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="status",
 *          description="status",
 *          type="boolean"
 *      )
 * )
 */
class Notification extends Model
{
    use SoftDeletes;

    public $table = 'notifications';

    protected $dates = ['deleted_at'];

    const NOTIFICATION_TYPE_NEW_BID = 10;

    public static $NOTIFICATION_MESSAGE = [
        self::NOTIFICATION_TYPE_NEW_BID => 'You have new bid on your car.'
    ];

    public $fillable = [
        'sender_id',
        'url',
        'action_type',
        'ref_id',
        'message',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'sender_id'   => 'int',
        'url'         => 'string',
        'ref_id'      => 'int',
        'action_type' => 'int',
        'message'     => 'string',
        'status'      => 'boolean'
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
        'delivery_status'
    ];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'action_type',
        'ref_id',
        'message',
        'delivery_status',
        'created_at',
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'action_type' => 'required',
        'message'     => 'required',
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'action_type' => 'required',
        'message'     => 'required',
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'action_type' => 'required',
        'message'     => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'notification_users')->withPivot('status');
    }

    /**
     * @return string
     */
    public function getUsersCsvAttribute()
    {
        return implode(",", $this->users->pluck('name')->all());
    }

    /**
     * @return string
     */
    public function getDeliveryStatusAttribute()
    {

        $delivery_status = 0;
        $delivery_status = NotificationUser::where('notification_id', $this->id)->pluck('status')->first();
        return $delivery_status;
    }
}
