<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Module;
use App\Models\News;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (App::environment() == 'staging') {
            $menu = Menu::find(5);
            $menu->status = 0;
            $menu->save();
        }
        $users = User::all()->count();
        $roles = Role::all()->count();
        $modules = Module::all()->count();
        $categories = Category::all()->count();
        $news = News::all()->count();
        BreadcrumbsRegister::Register();
        if (Auth::user()->hasRole('showroom-owner')) {
            return redirect(route('admin.makeBids.index'));
        }
        return view('admin.home')->with([
            'users'      => $users,
            'roles'      => $roles,
            'categories' => $categories,
            'news'       => $news,
            'modules'    => $modules]);
    }
}
