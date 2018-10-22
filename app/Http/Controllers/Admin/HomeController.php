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
        /*$row = 0;
$rows = [];
$autoLineEndings = ini_get('auto_detect_line_endings');
ini_set('auto_detect_line_endings', TRUE);

if (($handle = fopen(public_path() . '/csv/new.csv', "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
        if (count($data) <= 1) {
            continue;
        }
        $row++;
        if ($row == 1) {
            continue;
        }
        $rows[] = $data;
    }
    fclose($handle);
}
ini_set('auto_detect_line_endings', $autoLineEndings);
dd($rows);*/

        /*$row = 0;
        $rows = [];
        if (($handle1 = fopen(public_path() . '/csv/new.csv', "r")) !== FALSE) {
//            if (($handle2 = fopen(public_path() . '/csv/new.csv', "w")) !== FALSE) {
            while (($data = fgetcsv($handle1, 1000, ",")) !== FALSE) {
                if (count($data) <= 1) {
                    continue;
                }
                $row++;
                if ($row == 1) {
                    continue;
                }
                // Alter your data
                $rows[] = $data;
                $newRow[0] = '3';
                $newRow[1] = 'Mohsin';
                $newRow[2] = 'mohsin@asd.com';
                $newRow[3] = 'asd qwe12341';
                // Write back to CSV format
//                    fputcsv($handle2, $data);
            }
//                fclose($handle2);
//            }
            fclose($handle1);
        }
        dd($rows, $newRow);*/
        exec('php artisan queue:work --stop-when-empty');
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
        return view('admin.home')->with([
            'users'      => $users,
            'roles'      => $roles,
            'categories' => $categories,
            'news'       => $news,
            'modules'    => $modules]);
    }
}
