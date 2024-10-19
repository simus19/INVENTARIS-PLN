<?php

namespace Database\Seeders;

use App\Models\User_role_menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new User_role_menu();
        $data->roles_id = 1;
        $data->menus_id = 1;
        $data->save();
    }
}
