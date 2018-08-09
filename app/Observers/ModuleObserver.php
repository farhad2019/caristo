<?php
/**
 * Created by PhpStorm.
 * User: mohsinahmad
 * Date: 06-Apr-18
 * Time: 10:46 AM
 */

namespace App\Observers;

use App\Models\Menu;
use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;

class ModuleObserver
{
    protected $data;

    public function created(Module $module)
    {
        $pieces = preg_split('/(?=[A-Z])/', $module->name);
        $permissions = ['index', 'create', 'show', 'edit', 'destroy'];
        foreach ($permissions as $key => $permission) {
            $this->data['name'] = str_plural(lcfirst($module->name)) . '.' . $permission;
            $this->data['display_name'] = substr(join(" ", $pieces), 1);
            $this->data['description'] = ucwords($permission).' '.$module->slug;
            $ids[] = Permission::insertGetId($this->data);
        }
        $super_admin = Role::find(1);
        $super_admin->perms()->attach($ids);

        $max_position = Menu::all()->max('position');
        Menu::create([
            'name'     => str_plural(substr(join(" ", $pieces), 1)),
            'slug'     => str_plural(lcfirst($module->name)),
            'position' => $max_position + 1,
            'icon'     => $module->icon
        ]);
    }
}