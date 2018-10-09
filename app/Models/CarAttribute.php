<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property string type
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property MyCar cars
 *
 * @SWG\Definition(
 *      definition="CarAttribute",
 *      required={"type"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
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
class CarAttribute extends Model
{
    use SoftDeletes, Translatable;

    public $table = 'attributes';
    protected $dates = ['deleted_at'];
    protected $translatedAttributes = ['name'];
    protected $translationForeignKey = 'attribute_id';

    public $fillable = [
        'type'
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
    protected $visible = [
        'id',
        'name'
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'type' => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'type' => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'type' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cars()
    {
        return $this->belongsToMany(MyCar::class, 'car_attributes', 'car_id', 'attribute_id', 'id', 'id')->withPivot('value');
    }
}
