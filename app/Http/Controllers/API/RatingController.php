<?php

namespace App\Http\Controllers\API;

use App\Book;
use App\Http\Controllers\Controller;
use App\Http\Resources\RatingResource;
use App\Rating;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return RatingResource::collection(Rating::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "rate" => "required|integer|between:1,5",
            "book" => "required|exists:books,id"
        ]);
        if($this->hasVoted($request)){
            return response("شما قبلا زای داده اید");
        }
        if ($this->changeVote($request)){
            Rating::where('user_id',Auth::user()->getAuthIdentifier())
                ->where('book_id',$request->book)->update(["rate"=> $request->rate]);
            return response("امتیاز شما با موفقیت عوض شد");
        }
        $rating = new Rating($request->all());
        $rating->book()->associate($request->book);
        $rating->user()->associate(Auth::user());
        $rating->save();
        return response("رای شما با موفقیت ثبت شد.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function show(Rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rating $rating)
    {
        $rating->rate = $request->rate;
        $rating->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Rating $rating
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Rating $rating)
    {
        $rating->delete();
        return response("امتیاز حذف شد");

    }
    public function hasVoted(Request $request){
        $book1 = Rating::where('user_id',Auth::user()->getAuthIdentifier())
            ->where('book_id',$request->book)
            ->where('rate',$request->rate)->count();
        if ($book1 == 1)
            return true;
        return false;
    }
    public function changeVote(Request $request){
        $book1 = Rating::where('user_id',Auth::user()->getAuthIdentifier())
            ->where('book_id',$request->book)->count();
        if ($book1 > 0)
            return true;
        return false;


    }
}
