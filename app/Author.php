<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = ['firstname','lastname'];

    public function books(){
        return $this->hasMany('\App\Book');
    }
}
