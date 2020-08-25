<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class Rating extends Model
{
    protected $fillable = ['rate'];

    public function book(){
        return $this->belongsTo('\App\Book');
    }

    public function user(){
        return $this->belongsTo('\App\User');
    }


    public static function changeVote(Request $request) : bool
    {
        $rating = Rating::where([
            'user_id' => Auth::user()->getAuthIdentifier(),
            'book_id' => $request->book
        ])->count();

        return $rating > 0 ? true : false;
    }


    public static function hasVoted(Request $request) : bool
    {

        $rating = Rating::where([
            'user_id' => Auth::user()->getAuthIdentifier(),
            'book_id' => $request->book,
            'rate' => $request->rate
        ])->count();

         return $rating === 1 ? true : false ;
    }
}

