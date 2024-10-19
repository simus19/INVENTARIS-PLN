<?php

namespace Database\Seeders;

use App\Models\Menu_sub;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new Menu_sub();
        $data->menus_id = 1;
        $data->name = 'Role';
        $data->url = '/admin/role';
        $data->save();

        $data = new Menu_sub();
        $data->menus_id = 1;
        $data->name = 'Prodi';
        $data->url = '/admin/prodi';
        $data->save();

        $data = new Menu_sub();
        $data->menus_id = 1;
        $data->name = 'Menu & Sub Menu';
        $data->url = '/admin/menu';
        $data->save();
        
        $data = new Menu_sub();
        $data->menus_id = 1;
        $data->name = 'Admin User';
        $data->url = '/admin/user';
        $data->save();

    }
}
