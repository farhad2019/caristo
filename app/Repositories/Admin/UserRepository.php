<?php

namespace App\Repositories\Admin;

use App\Models\User;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UserRepository
 * @package App\Repositories\Admin
 * @version April 2, 2018, 9:11 am UTC
 *
 * @method User findWithoutFail($id, $columns = ['*'])
 * @method User find($id, $columns = ['*'])
 * @method User first($columns = ['*'])
*/
class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'password',
        'remember_token'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }

    public function attachRole($userId, $roleId){
        $user = $this->findWithoutFail($userId);
        $user->roles()->attach($roleId);
        $user->save();
    }
    public function detachRole($userId, $roleId){
        $user = $this->findWithoutFail($userId);
        $user->roles()->detach($roleId);
        $user->save();
    }
}
