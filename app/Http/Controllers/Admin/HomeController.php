<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewJobEvent;
use App\Helper\BreadcrumbsRegister;
use App\Http\Controllers\Controller;
use App\Models\NotificationUser;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\MyCarRepository;
use App\Repositories\Admin\NewsRepository;
use App\Repositories\Admin\NotificationRepository;
use App\Repositories\Admin\RoleRepository;
use App\Repositories\Admin\UserRepository;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var RoleRepository
     */
    protected $roleRepository;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var NewsRepository
     */
    protected $newsRepository;

    /**
     * @var MyCarRepository
     */
    protected $carRepository;

    /**
     * Create a new controller instance.
     * @param UserRepository $userRepo
     * @param RoleRepository $roleRepo
     * @param CategoryRepository $categoryRepo
     * @param NewsRepository $newsRepo
     * @param MyCarRepository $carRepo
     */
    public function __construct(UserRepository $userRepo, RoleRepository $roleRepo, CategoryRepository $categoryRepo, NewsRepository $newsRepo, MyCarRepository $carRepo, NotificationRepository $notificationRepository)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepo;
        $this->roleRepository = $roleRepo;
        $this->categoryRepository = $categoryRepo;
        $this->newsRepository = $newsRepo;
        $this->carRepository = $carRepo;
    }
//unlink media file from folder

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = $this->userRepository->all()->count() - 2;
        $roles = $this->roleRepository->all()->count();
        $categories = $this->categoryRepository->all()->count();
        $news = $this->newsRepository->all()->count();
        $cars = $this->carRepository->all()->count();
        $notifications = Auth::user()->notificationMaster()->whereHas('details', function ($details){
            return $details->where('status', NotificationUser::STATUS_DELIVERED);
        })->where('notification_users.deleted_at', null)->orderBy('created_at', 'DESC')->get();

        BreadcrumbsRegister::Register();
        if (Auth::user()->hasRole('showroom-owner')) {
            return redirect(route('admin.tradeInCars.index'));
        }

        return view('admin.home')->with([
            'notifications' => $notifications,
            'users'         => $users,
            'roles'         => $roles,
            'categories'    => $categories,
            'news'          => $news,
            'cars'          => $cars
        ]);
    }


}