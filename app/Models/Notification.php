<?php

namespace App\Models;

use Iatstuti\Database\Support\CascadeSoftDeletes;
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
 * @property NotificationUser details
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
    use SoftDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['details'];
    public $table = 'notifications';
    protected $dates = ['deleted_at'];

    const NOTIFICATION_TYPE_TRADE_IN_NEW_BID = 10;
    const NOTIFICATION_TYPE_EVALUATION_NEW_BID = 20;
    const NOTIFICATION_TYPE_TRADE_IN = 30;
    const NOTIFICATION_TYPE_ALERT = 40;
    const NOTIFICATION_TYPE_COMMENT = 50;
    const NOTIFICATION_TYPE_COMMENT_UPDATE = 60;

    public static $NOTIFICATION_ACTION_TYPE = [
        self::NOTIFICATION_TYPE_TRADE_IN_NEW_BID   => 'New offer alert.',
        self::NOTIFICATION_TYPE_EVALUATION_NEW_BID => 'New evolution request alert.',
        self::NOTIFICATION_TYPE_TRADE_IN           => 'New trade-in alert.',
        self::NOTIFICATION_TYPE_ALERT              => 'App alert.',
        self::NOTIFICATION_TYPE_COMMENT            => 'Comment alert.',
        self::NOTIFICATION_TYPE_COMMENT_UPDATE     => 'Comment alert.'
    ];

    public static $NOTIFICATION_MESSAGE = [
        self::NOTIFICATION_TYPE_TRADE_IN_NEW_BID   => 'You have new offer on your car.',
        self::NOTIFICATION_TYPE_EVALUATION_NEW_BID => 'Your evolution request is available to view now.!!',
        self::NOTIFICATION_TYPE_TRADE_IN           => 'You have new TradeIn Request.',
        self::NOTIFICATION_TYPE_COMMENT            => 'New comment on news.',
        self::NOTIFICATION_TYPE_COMMENT_UPDATE     => 'comment updated on news.'
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
        'sent_to.*'     => 'required',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
        //return $this->belongsToMany(User::class, 'notification_users')->withPivot('status');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'notification_users')->withPivot('status');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany(NotificationUser::class, 'notification_id');
    }

    /**
     * @return string
     */
    public function getUsersCsvAttribute()
    {
        return implode(", ", $this->users->pluck('name')->all());
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
