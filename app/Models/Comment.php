<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Comment",
 *      required={"user_id", "news_id", "comment_text"},
 *
 *      @SWG\Property(
 *          property="parent_id",
 *          description="parent_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="news_id",
 *          description="news_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="user_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="comment_text",
 *          description="comment_text",
 *          type="string"
 *      )
 * )
 */
class Comment extends Model
{
    use SoftDeletes;

    public $table = 'comments';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'id',
        'user_id',
        'news_id',
        'comment_text',
        'created_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'comment_text' => 'string'
    ];

    /**
     * The objects that should be append to toArray.
     *
     * @var array
     */
    protected $with = [
        'user'
    ];

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
        'user_id'      => 'required',
        'news_id'      => 'required',
        'comment_text' => 'required',
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'id'           => 'required',
        'user_id'      => 'required',
        'comment_text' => 'required',
        'created_at'   => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'user_id'      => 'required',
        'news_id'      => 'required',
        'comment_text' => 'required'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
