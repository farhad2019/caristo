<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="NewsInteraction",
 *      required={"id", "user_id", "news_id", "type", "created_at", "updated_at", "deleted_at"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
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
 *          property="news_id",
 *          description="news_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="type",
 *          description="type",
 *          type="string"
 *      )
 * )
 */
class NewsInteraction extends Model
{
    use SoftDeletes;

    public $table = 'news_interactions';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'id',
        'user_id',
        'news_id',
        'type',
        'created_at',
        'updated_at',
        'deleted_at'
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
        'id' => 'required',
        'user_id' => 'required',
        'news_id' => 'required',
        'type' => 'required',
        'created_at' => 'required',
        'updated_at' => 'required',
        'deleted_at' => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'id' => 'required',
        'user_id' => 'required',
        'news_id' => 'required',
        'type' => 'required',
        'created_at' => 'required',
        'updated_at' => 'required',
        'deleted_at' => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'id' => 'required',
        'user_id' => 'required',
        'news_id' => 'required',
        'type' => 'required',
        'created_at' => 'required',
        'updated_at' => 'required',
        'deleted_at' => 'required'
    ];

    
}
