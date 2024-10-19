<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->roles_id = 1;
        $user->name = "Administrator";
        $user->email = "administrator@gmail.com";
        $user->password = "admin123";
        $user->role_verified_is = 1;
        $user->save();
    }
}
