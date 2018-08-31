<?php

namespace App\Repositories\Admin;

use App\Helper\Utils;
use App\Models\WalkThroughTranslation;
use Illuminate\Support\Facades\App;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class WalkThroughTranslationRepository
 * @package App\Repositories\Admin
 * @version August 16, 2018, 9:23 am UTC
 *
 * @method WalkThroughTranslation findWithoutFail($id, $columns = ['*'])
 * @method WalkThroughTranslation find($id, $columns = ['*'])
 * @method WalkThroughTranslation first($columns = ['*'])
 */
class WalkThroughTranslationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return WalkThroughTranslation::class;
    }
}