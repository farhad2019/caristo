<?php

namespace App\Repositories\Admin;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
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

    /**
     * @param $userId
     * @param $roleId
     */
    public function attachRole($userId, $roleId)
    {
        $user = $this->findWithoutFail($userId);
        $user->roles()->attach($roleId);
        $user->save();
    }

    /**
     * @param $userId
     * @param $roleId
     */
    public function detachRole($userId, $roleId)
    {
        $user = $this->findWithoutFail($userId);
        $user->roles()->detach($roleId);
        $user->save();
    }

    /**
     * @param $email
     * @return mixed
     */
    public function getUserByEmail($email)
    {
        return $this->model->whereEmail($email)->first();
    }

    /**
     * @param Request $request
     * @param CategoryRepository $categoryRepo
     * @return array
     */
    public function findFavoriteNews(Request $request, CategoryRepository $categoryRepo)
    {
        $limit = $request->get('limit', null);
        $offset = $request->get('offset', null);

        $category_id = $request->get('category_id', 0);
        $categories = [];
        if ($category_id > 0) {
            $categoryModel = $categoryRepo->findWithoutFail($category_id);
            $category = $categoryModel->toArray();
            $category['news'] = $this->getChildFavorites($categoryModel, $limit, $offset);
            $categories[] = $category;
        } else {
            foreach ($categoryRepo->getRootCategories() as $rootCategory) {
                $category = $rootCategory->toArray();
                $category['news'] = $this->getChildFavorites($rootCategory, $limit, $offset);
                $categories[] = $category;
            }
        }
        return $categories;
    }

    /**
     * @param Category $category
     * @param null $limit
     * @param null $offset
     * @return mixed
     */
    private function getChildFavorites(Category $category, $limit = null, $offset = null)
    {
        $ret = [];
        $query = \Auth::user()->favorites()->orderBy('news.category_id');

        if ($limit) {
            $query->limit($limit);
        }

        if ($offset && $limit) {
            $query->skip($offset);
        }

        if ($category->childCategory()->count() > 0) {
            $ret = $query->whereIn('category_id', $category->childCategory()->pluck('id')->toArray());
            // ->selectRaw("news.*, $category->id as category_id");
        } else {
            $ret = $query->where('category_id', $category->id);
        }
        return $ret->get()->toArray();
    }
}