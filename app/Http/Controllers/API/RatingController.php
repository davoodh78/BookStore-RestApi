<?php

namespace App\Http\Controllers\API;

use App\Book;
use App\Http\Controllers\Controller;
use App\Rating;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Rating::all());
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
            "book" => "required"
        ]);
        // در صورتی که کاربر با همین امتیاز به این کتاب رای داده باشد این دستورات اجرا میشوند.
        $book1 = Rating::where('user_id',Auth::user()->getAuthIdentifier())
            ->where('book_id',$request->book)
            ->where('rate',$request->rate)->count();
        if($book1 == 1){
            return response("شما قبلا زای داده اید");
        }
        //---------------------------------------------------------------------------
        // در صورتی که امتیاز کاربر به این کتاب عوض شده باشد این دستورات اجرا می شوند
        $book1 = Rating::where('user_id',Auth::user()->getAuthIdentifier())
            ->where('book_id',$request->book)->count();
        if ($book1 > 0){
            $rating1 = Rating::where('user_id',Auth::user()->getAuthIdentifier())
                ->where('book_id',$request->book)->update(["rate"=> $request->rate]);
            return response("امتیاز شما با موفقیت عوض شد");
        }
        //-----------------------------------------------------------------------------
        // اگر کاربر بخواهد برای اولین بار به این کتاب امتیاز بدهد این دستورات اجرا می شوند.
        $rating = new Rating;
        $book = Book::find($request->book);
        $rating->book()->associate($book);
        $rating->user()->associate(Auth::user());
        $rating->rate = $request->rate;
        $rating->save();
        return response("رای شما با موفقیت ثبت شد.");
        //---------------------------------------------------------------------------


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
}
