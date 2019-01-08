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
 * @property string option_array
 * @property string type_text
 * @property string image
 *
 * @property MyCar cars
 * @property AttributeOption options
 * @property Media media
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

    const TEXT = 10;
    const NUMBER = 20;
    const SELECT_SINGLE = 30;
    const SELECT_MULTIPLE = 40;
    /*const FILE_SINGLE = 50;
    const FILE_MULTIPLE = 60;*/

    public static $ATTRIBUTE_TYPES = [
        self::TEXT          => 'text',
        self::NUMBER        => 'number',
        self::SELECT_SINGLE => 'select - box',
        /*self::SELECT_MULTIPLE => 'select - multiple',
        self::FILE_SINGLE     => 'file - single',
        self::FILE_MULTIPLE   => 'file - multiple'*/
    ];

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
    protected $with = [
        'options'
    ];

    /**
     * The attributes that should be append to toArray.
     *
     * @var array
     */
    protected $appends = [
        'option_array',
        'image',
        'type_text'
    ];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'name',
        'type',
        'image',
        'option_array'
//        'options'
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'type' => 'required',
        'name' => 'required|max:20',
        'opt'  => 'sometimes',
        'icon' => 'required|image|mimes:jpg,jpeg,png'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'type' => 'required',
        'name' => 'required|max:20',
        //'icon' => 'required',
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
        return 'attribute';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cars()
    {
        return $this->belongsToMany(MyCar::class, 'car_attributes', 'car_id', 'attribute_id', 'id', 'id')->withPivot('value');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(AttributeOption::class, 'attribute_id');
    }

    /**
     * @return mixed
     */
    public function getOptionArrayAttribute()
    {
        return (!empty($this->options)) ? $this->options->pluck('option_array') : null;
    }

    /**
     * @return mixed
     */
    public function getTypeTextAttribute()
    {
        return self::$ATTRIBUTE_TYPES[$this->type];
    }

    /**
     * @return mixed
     */
    public function getImageAttribute()
    {
        return ($this->media->count() > 0) ? $this->media[0]->file_url : null;
    }
}
