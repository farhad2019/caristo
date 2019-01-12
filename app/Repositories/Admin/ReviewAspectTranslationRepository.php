<?php

namespace App\Repositories\Admin;

use App\Models\ReviewAspectTranslation;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ReviewAspectRepository
 * @package App\Repositories\Admin
 * @version January 11, 2019, 11:43 am UTC
 *
 * @method ReviewAspectTranslation findWithoutFail($id, $columns = ['*'])
 * @method ReviewAspectTranslation find($id, $columns = ['*'])
 * @method ReviewAspectTranslation first($columns = ['*'])
 */
class ReviewAspectTranslationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'created_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ReviewAspectTranslation::class;
    }
}
