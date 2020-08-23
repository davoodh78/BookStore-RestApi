<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $fillable = ['name','address'];
    public function books(){
        return $this->hasMany("\App\Book");
    }
}
