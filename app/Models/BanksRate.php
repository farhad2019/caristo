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
 *      definition="BanksRate",
 *      required={"id", "title", "phone_no", "address", "rate", "type", "created_at", "updated_at", "deleted_at"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="title",
 *          description="title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="phone_no",
 *          description="phone_no",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="address",
 *          description="address",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="rate",
 *          description="rate",
 *          type="number",
 *          format="float"
 *      ),
 *      @SWG\Property(
 *          property="type",
 *          description="type",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class BanksRate extends Model
{
    use SoftDeletes;

    const BANK = 10;
    const INSURANCE = 20;

    public static $BANK_TYPE_TEXT = [
        self::BANK    => 'Bank',
        self::INSURANCE => 'Insurance'
    ];

    public $table = 'bank_insurances';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'id',
        'title',
        'phone_no',
        'address',
        'rate',
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
        'title' => 'string',
        'phone_no' => 'string',
        'address' => 'string',
        'rate' => 'float'
    ];

    /**
     * The objects that should be append to toArray.
     *
     * @var array
     */
     protected $with = [
         'media'
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
    protected $visible = [
        'id',
        'title',
        'phone_no',
        'address',
        'rate',
        'type',
        'created_at',
        'media'
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'phone_no' => 'required|phone',
        'address' => 'required',
        'rate' => 'required',
        'type' => 'required',
        'media'   => 'required'

    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'title' => 'required',
        'phone_no' => 'required|phone',
        'address' => 'required',
        'rate' => 'required',
        'type' => 'required',
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
        'id' => 'required',
        'title' => 'required',
        'phone_no' => 'required',
        'address' => 'required',
        'rate' => 'required',
        'type' => 'required',
        'created_at' => 'required',
        'updated_at' => 'required',
        'deleted_at' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function media()
    {
        return $this->morphMany(Media::class, 'instance');
    }

    /**
     * @return string
     */
    public function getMorphClass()
    {
        return 'bank';
    }


}
