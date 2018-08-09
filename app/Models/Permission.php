<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\EntrustPermission;

/**
 * @property integer name
 * @property integer display_name
 * @property integer description
 * @SWG\Definition(
 *      definition="Permission",
 *      required={"name"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class Permission extends EntrustPermission
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'display_name',
        'description'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];
}