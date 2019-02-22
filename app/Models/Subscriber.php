<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @SWG\Definition(
 *      definition="Subscriber",
 *      required={"email"},
 *      @SWG\Property(
 *          property="email",
 *          description="email",
 *          type="string"
 *      )
 * )
 */
class Subscriber extends Model
{
    public $table = 'subscribers';
    public $timestamps = false;

    public $fillable = [
        'email'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'email' => 'string'
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
        'email' => 'required|email|unique:subscribers,email'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'email' => 'required|email|unique:subscribers,email'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'email' => 'required|email|unique:subscribers,email'
    ];

    
}
