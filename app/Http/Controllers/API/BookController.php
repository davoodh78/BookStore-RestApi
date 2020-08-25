<?php

namespace App\Http\Controllers\API;

use App\Author;
use App\Book;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
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
    public function store(BookRequest $request)
    {

        $book = new Book($request->all());

        $book->author()->associate($request->author);
        $book->publisher()->associate($request->publisher);
        $book->warehouse()->associate($request->warehouse);
        $book->save();

        return new BookResource($book);
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
        $request->validate([
            "price" => "integer",
            "quantity" => "integer",
        ]);

        Book::find($book->id)->update($request->all());

        return response('کتاب با موفقیت ویرایش شد.');
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
