<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_role = new Role();
        $admin_role->name = "Administrator";
        $admin_role->save();
        
        $admin_role = new Role();
        $admin_role->name = "User";
        $admin_role->save();

    }
}
