<?php

namespace App\Http\Controllers\API;

use App\Book;
use App\Http\Controllers\Controller;
use App\Http\Requests\RatingRequest;
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
    public function store(RatingRequest $request)
    {

        if(Rating::hasVoted($request))            //when You have already rated
        {
            return response('شما قبلا امتیاز داده اید.');
        }


        if (Rating::changeVote($request))        //when you want to change your rating
        {
            Rating::where([
                'user_id' => Auth::user()->getAuthIdentifier(),
                'book_id' => $request->book
            ])->update(["rate"=> $request->rate]);

            return response('.امتیاز شما با موفقیت عوض شد');
        }


        $rating = new Rating($request->all());

        $rating->book()->associate($request->book);
        $rating->user()->associate(Auth::user());

        $rating->save();

        return response('امتیاز شما با موفقیت ثبت شد.');
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

        return response('امتیاز حذف شد');

    }


}
