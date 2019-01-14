<?php

namespace App\Repositories\Admin;

use App\Models\ConsultancyRequest;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ConsultancyRequestRepository
 * @package App\Repositories\Admin
 * @version January 14, 2019, 8:22 am UTC
 *
 * @method ConsultancyRequest findWithoutFail($id, $columns = ['*'])
 * @method ConsultancyRequest find($id, $columns = ['*'])
 * @method ConsultancyRequest first($columns = ['*'])
*/
class ConsultancyRequestRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'car_id',
        'name',
        'email',
        'phone',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ConsultancyRequest::class;
    }
}
