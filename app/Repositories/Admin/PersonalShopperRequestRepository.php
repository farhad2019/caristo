<?php

namespace App\Repositories\Admin;

use App\Models\PersonalShopperRequest;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PersonalShopperRequestRepository
 * @package App\Repositories\Admin
 * @version January 14, 2019, 8:24 am UTC
 *
 * @method PersonalShopperRequest findWithoutFail($id, $columns = ['*'])
 * @method PersonalShopperRequest find($id, $columns = ['*'])
 * @method PersonalShopperRequest first($columns = ['*'])
*/
class PersonalShopperRequestRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'car_id',
        'name',
        'email',
        'phone'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PersonalShopperRequest::class;
    }
}
