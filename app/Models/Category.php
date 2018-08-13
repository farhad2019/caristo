<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Category",
 *      required={"slug"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="slug",
 *          description="slug",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="user_id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class Category extends Model
{
    use SoftDeletes;

    use Translatable;

    public $table = 'category';

    public $translatedAttributes = ['name'];

    protected $dates = ['deleted_at'];


    public $fillable = [
        'slug'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'slug' => 'string'
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

    ];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'name',
        'user_id',
//        'slug',
        'created_at',
        'updated_at',
//        'deleted_at'
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'slug' => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'slug' => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'slug' => 'required'
    ];

    public function Variants()
    {
        return $this->hasMany(\App\Models\ItemVariant::class, 'item_id', 'id');
    }

    public function Media()
    {
        return $this->morphMany(MediaFi::class, 'item_id', 'id');
    }

}
