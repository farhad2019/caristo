<?php

namespace App\Models;

use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\EntrustRole;
use Zizaco\Entrust\Traits\EntrustUserTrait;

/**
 *
 * @property integer id
 * @property string name
 * @property string display_name
 * @property string description
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property User user
 *
 * @SWG\Definition(
 *      definition="Role",
 *      required={"name", "description"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class Role extends EntrustRole
{
    use CascadeSoftDeletes;

    protected $cascadeDeletes = ['user'];

    use SoftDeletes {
        restore as private restoreA;
    }
    use EntrustUserTrait {
        restore as private restoreB;
    }

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

    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }

    public function user()
    {
        return $this->belongsToMany('App\Models\User');
    }
}