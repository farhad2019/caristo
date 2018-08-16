<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer status
 * @property integer id
 * @property integer sort_by
 *
 * @SWG\Definition(
 *      definition="Menu",
 *      required={"name"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="icon",
 *          description="icon",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="slug",
 *          description="slug",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="position",
 *          description="position",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="is_protected",
 *          description="is_protected",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="status",
 *          description="status",
 *          type="boolean"
 *      )
 * )
 */
class Menu extends Model
{
    use SoftDeletes;

    public $table = 'menus';

    protected $dates = ['deleted_at'];

    public $fillable = ['name', 'slug', 'position', 'icon', 'status', 'sort_by'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name'         => 'string',
        'icon'         => 'string',
        'slug'         => 'string',
        'position'     => 'int',
        'is_protected' => 'boolean',
        'status'       => 'boolean'
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
        'name' => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'name' => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'name' => 'required'
    ];


}
