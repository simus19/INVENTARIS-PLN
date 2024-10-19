<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_role_menu extends Model
{
    protected $guarded = ['id'];
    
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menus_id');
    }
}
