<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    public function books(){
        return $this->hasMany("\App\Book");
    }
}
