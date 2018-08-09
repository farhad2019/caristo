<?php

namespace App\Repositories\Admin;

use App\Models\Menu;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MenuRepository
 * @package App\Repositories\Admin
 * @version July 16, 2018, 9:58 am UTC
 *
 * @method Menu findWithoutFail($id, $columns = ['*'])
 * @method Menu find($id, $columns = ['*'])
 * @method Menu first($columns = ['*'])
*/
class MenuRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Menu::class;
    }

}
