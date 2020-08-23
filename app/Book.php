<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
	protected $fillable = ['title','price','quantity'];
    public function author(){
        return $this->belongsTo("\App\Author");
    }
    public function publisher(){
        return $this->belongsTo("\App\Publisher");
    }
    public function ratings(){
        return $this->hasMany("\App\Rating");
    }
    public function warehouse(){
        return $this->belongsTo("\App\Warehouse");
    }

}
