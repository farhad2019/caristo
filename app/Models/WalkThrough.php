<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property int sort
 * @property int type
 * @property string title
 * @property string content
 *
 * @SWG\Definition(
 *      definition="WalkThrough",
 *      required={"id"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="sort",
 *          description="sort",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class WalkThrough extends Model
{
    use SoftDeletes, Translatable;

    const TYPE_TEXT = 10;
    const TYPE_IMAGE = 20;
    const TYPE_VIDEO = 30;
    const TYPE_TEXT_IMAGE = 40;
    const TYPE_TEXT_IMAGE_URL = 50;
    const TYPE_TEXT_VIDEO = 60;
    const TYPE_TEXT_VIDEO_URL = 70;

    public static $TYPES_TEXT = [
        self::TYPE_TEXT           => 'Text Only',
        self::TYPE_IMAGE          => 'Image Only',
        self::TYPE_VIDEO          => 'Video Only',
        self::TYPE_TEXT_IMAGE     => 'Text with Image',
        self::TYPE_TEXT_IMAGE_URL => 'Text with Image URL',
        self::TYPE_TEXT_VIDEO     => 'Text with Video',
        self::TYPE_TEXT_VIDEO_URL => 'Text with Video URL',
    ];

    public $table = 'walkthrough';

    protected $dates = ['deleted_at'];

    public $translatedAttributes = ['title', 'content'];

    public $fillable = [
        'id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'sort' => 'int'
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
//        'id' => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
//        'id' => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [
//        'id' => 'required'
    ];


    public function getTypeTextAttribute()
    {
        return self::$TYPES_TEXT[$this->type];
    }
}
