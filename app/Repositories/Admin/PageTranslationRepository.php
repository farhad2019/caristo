<?php

namespace App\Repositories\Admin;

use App\Models\PageTranslation;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PageTranslationRepository
 * @package App\Repositories\Admin
 * @version July 13, 2018, 6:53 am UTC
 *
 * @method PageTranslation findWithoutFail($id, $columns = ['*'])
 * @method PageTranslation find($id, $columns = ['*'])
 * @method PageTranslation first($columns = ['*'])
*/
class PageTranslationRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return PageTranslation::class;
    }
}
