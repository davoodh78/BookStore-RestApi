<?php

namespace App\Http\Controllers\API;

use App\Author;
use App\Book;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Publisher;
use App\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return BookResource::collection(Book::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return BookResource
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => "required",
            "price" => "required|integer",
            "quantity" => "required|integer"
        ]);

        $b = new Book;
        $b->title = $request->title;
        $b->price = $request->price;
        $a = Author::find($request->author);
        $b->author()->associate($a);
        $p = Publisher::find($request->publisher);
        $b->publisher()->associate($p);
        $w = Warehouse::find($request->warehouse);
        $b->warehouse()->associate($w);
        $b->quantity = $request->quantity;
        $b->save();
        return new BookResource($b);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return BookResource
     */
    public function show(Book $book)
    {
        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return BookResource
     */
    public function update(Request $request, Book $book)
    {
        if(! is_null($request->title))
            $book->title = $request->title;
        if(! is_null($request->price))
            $book->price = $request->price;
        if(! is_null($request->quantity))
            $book->quantity = $request->quantity;
        $book->save();
        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Book $book
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response('کتاب با موفقیت حذف شد');
    }
}
