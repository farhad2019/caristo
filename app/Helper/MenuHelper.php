<?php
/**
 * Created by PhpStorm.
 * User: mohsinahmad
 * Date: 10-Apr-18
 * Time: 12:08 PM
 */

namespace App\Helper;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class MenuHelper
{
    public static function staticGeneratePermittedMenus()
    {
        $menus = Menu::all()->sortBy('position');
        $listItems = [];

        foreach ($menus as $key => $menu) {
            $permName = ($menu->slug === "dashboard") ? "dashboard" : $menu->slug . ".index";
            if (Auth::user()->can($permName)) {
                $listItems[$key]['name'] = $menu->name;
                $listItems[$key]['slug'] = $permName;
                $listItems[$key]['icon'] = $menu->icon;
                $listItems[$key]['status'] = $menu->status;
            }
        }
        return self::GenerateLi($listItems);
    }

    protected static function GenerateLi($data)
    {
        $li = '';
        $route = '';
        foreach ($data as $datum) {
            if ($datum['status']) {
                $route = (Request::routeIs('*.' . $datum['slug'] . '*')) ? 'active' : '';
                $li .= '<li class="' . $route . '">';
                $slug = $datum['slug'];
                $li .= '<a href="' . route("admin.$slug") . '">';
                $icon = $datum['icon'];
                $li .= '<i class="' . $icon . '"></i>';
                $name = $datum['name'];
                $li .= '<span>' . $name . '</span>';
                $li .= '</a></li>';
                $route = '';
            }
        }
        return $li;
    }
}