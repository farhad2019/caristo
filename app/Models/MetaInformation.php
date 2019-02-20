<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @property mixed $region
 * @property mixed $car
 */
class MetaInformation extends Model
{
    use SoftDeletes;

    public $table = 'meta_information';

    protected $dates = ['deleted_at'];

    const CAR_META = 10;
    const NEWS_META = 20;

    public $fillable = [
        'id',
        'instance_type',
        'instance_id',
        'title',
        'tags',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'            => 'int',
        'instance_type' => 'string',
        'instance_id'   => 'int',

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
        'title',
        'tags',
        'description'
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function instance()
    {
        return $this->morphTo();
    }
}
