<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property integer user_id
 * @property integer notification_id
 * @property integer status
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property Notification notification
 * @property User user
 *
 * Class NotificationUser
 * @package App\Models
 */
class NotificationUser extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public $table = 'notification_users';


    const STATUS_SENT = 10;
    const STATUS_DELIVERED = 20;
    const STATUS_READ = 30;

    public static $NOTIFICATION_STATUS_TEXT = [
        self::STATUS_SENT      => 'Notification Sent Successfully',
        self::STATUS_DELIVERED => 'Notification delivered to user.',
        self::STATUS_READ      => 'Notification read by user.',
    ];

    public $fillable = [
        'notification_id',
        'user_id',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

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
    public static $rules = [];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
