<?php

namespace Tests\Unit;

use App\Book;
use App\User;
use Tests\TestCase;

class RatingTest extends TestCase
{
    public function testRate(){
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $book = factory(Book::class)->create([
            'title' => 'لیرشاه',
            'price' => 20000,
            'author_id' => 3,
            'publisher_id' => 3,
            'warehouse_id' => 1,
            'quantity' => 24
        ]);

        $ratingForm = [
            'book' => $book->id,
            'user' => $user->id,
            'rate' => 4
        ];

        $response = $this->postJson('api/ratings' , $ratingForm , ['accept' => 'application/json'])
            ->assertStatus(200)
            ->assertSee('امتیاز شما با موفقیت ثبت شد.');

    }

}
