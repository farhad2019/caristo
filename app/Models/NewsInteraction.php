<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property News news
 *
 * @SWG\Definition(
 *      definition="NewsInteraction",
 *      required={"news_id", "type"},
 *      @SWG\Property(
 *          property="news_id",
 *          description="news_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="type",
 *          description="type, 10=View, 20=like, 30=favorite",
 *          type="integer"
 *      )
 * )
 */
class NewsInteraction extends Model
{
    use SoftDeletes;

    public $table = 'news_interactions';

    const TYPE_VIEW = 10;
    const TYPE_LIKE = 20;
    const TYPE_FAVORITE = 30;

    public static $TYPES = [
        self::TYPE_VIEW     => "View",
        self::TYPE_LIKE     => "Like",
        self::TYPE_FAVORITE => "Favorite",
    ];

    protected $dates = ['deleted_at'];


    public $fillable = [
        'id',
        'user_id',
        'news_id',
        'type',
        'created_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'string'
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
        'user_id' => 'required',
        'news_id' => 'required',
        'type'    => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'id'      => 'required',
//        'user_id'    => 'required',
        'news_id' => 'required',
        'type'    => 'required',
//        'created_at' => 'required',
//        'updated_at' => 'required',
//        'deleted_at' => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
//        'user_id' => 'required',
        'news_id' => 'required',
        'type'    => [
            'required',
            'integer',
            'in:10,20,30',
        ]
    ];


    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
