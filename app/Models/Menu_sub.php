<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu_sub extends Model
{
    protected $guarded = ['id'];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menus_id');
    }
}
