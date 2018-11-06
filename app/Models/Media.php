<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property integer instance_id
 * @property string instance_type
 * @property integer media_type
 * @property string title
 * @property string filename
 * @property string file_url
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property string instance
 *
 * @SWG\Definition(
 *      definition="Media",
 *      required={"id", "instance_id", "instance_type", "title", "filename", "created_at"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="instance_id",
 *          description="instance_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="instance_type",
 *          description="instance_type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="title",
 *          description="title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="filename",
 *          description="filename",
 *          type="string"
 *      )
 * )
 */
class Media extends Model
{
    use SoftDeletes;
    public $table = 'media_files';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'instance_id',
        'instance_type',
        'title',
        'media_type',
        'filename',
        'file_url'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'instance_id'   => 'int',
        'instance_type' => 'string',
        'title'         => 'string',
        'filename'      => 'string',
        'file_url'      => 'string',
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
        'file_url'
    ];

    /**
     * The attributes that should be visible in toArray.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'title',
        'filename',
        'media_type',
        'file_url',
        'created_at'
    ];

    /**
     * Validation create rules
     *
     * @var array
     */
    public static $rules = [
        'id'            => 'required',
        'instance_id'   => 'required',
        'instance_type' => 'required',
        'title'         => 'required',
        'filename'      => 'required',
        'created_at'    => 'required'
    ];

    /**
     * Validation update rules
     *
     * @var array
     */
    public static $update_rules = [
        'id'            => 'required',
        'instance_id'   => 'required',
        'instance_type' => 'required',
        'title'         => 'required',
        'filename'      => 'required',
        'created_at'    => 'required'
    ];

    /**
     * Validation api rules
     *
     * @var array
     */
    public static $api_rules = [];

    /**
     * @return string
     */
    public function getFileUrlAttribute()
    {
        if ($this->media_type == News::TYPE_IMAGE) {
            return ($this->filename && file_exists(storage_path('app/' . $this->filename))) ? route('api.resize', ['img' => $this->filename]) : route('api.resize', ['img' => 'public/no_image.png', 'w=50', 'h=50']);
        } elseif ($this->media_type == News::TYPE_VIDEO) {
            return $this->filename;
        }

        /*return ($this->filename) ? route('api.resize', ['img' => $this->filename]) : route('api.resize', ['img' => 'users/user.png']);*/
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function instance()
    {
        return $this->morphTo();
    }
}
