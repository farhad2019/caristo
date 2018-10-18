<?php

namespace App\Repositories\Admin;

use App\Models\ContactUs;
use Illuminate\Support\Facades\Auth;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ContactUsRepository
 * @package App\Repositories\Admin
 * @version July 14, 2018, 6:36 am UTC
 *
 * @method ContactUs findWithoutFail($id, $columns = ['*'])
 * @method ContactUs find($id, $columns = ['*'])
 * @method ContactUs first($columns = ['*'])
 */
class ContactUsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'name',
        'email',
        'subject',
        'status',
        'created_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ContactUs::class;
    }

    public function saveRecord($request)
    {
        $input = $request->all();
        if (Auth::id()) {
            $input['user_id'] = Auth::id();
        }
        $contactUs = $this->create($input);
        return $contactUs;
    }
}
