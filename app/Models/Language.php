<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property string code
 * @property string name
 * @property integer status
 * @property integer created_at
 * @property integer updated_at
 * @property integer deleted_at
 *
 * @SWG\Definition(
 *      definition="Language",
 *      required={"code", "title", "native_name", "direction", "status"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="code",
 *          description="code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="title",
 *          description="title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="native_name",
 *          description="native_name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="direction",
 *          description="direction",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="status",
 *          description="status",
 *          type="boolean"
 *      )
 * )
 */
class Language extends Model
{
    use SoftDeletes;

    public $table = 'locales';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'code',
        'title',
        'native_name',
        'direction',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'code'        => 'string',
        'title'       => 'string',
        'native_name' => 'string',
        'direction'   => 'string',
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
    protected $appends = [];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'code',
        'title',
        'native_name',
        'direction'
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'code'        => 'required',
        'title'       => 'required',
        'native_name' => 'required',
        'direction'   => 'required',
        'status'      => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'code'        => 'required',
        'title'       => 'required',
        'native_name' => 'required',
        'direction'   => 'required',
        'status'      => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'code'        => 'required',
        'title'       => 'required',
        'native_name' => 'required',
        'direction'   => 'required',
        'status'      => 'required'
    ];


}
