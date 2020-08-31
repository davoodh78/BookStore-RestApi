<?php

namespace Tests\Unit;

use App\Book;
use App\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BookTest extends TestCase
{
    public function testCreateBook()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $createForm = [
            'title' => 'جای خالی سلوچ',
            'price' => 35000,
            'author' => 5,
            'publisher' => 2,
            'warehouse' => 1,
            'quantity' => 60
        ];

        $response = $this->postJson('api/books' , $createForm , ['accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'price',
                    'rate',
                    'author',
                    'publisher',
                    'status'
                ]


            ]);
    }


    public function testGetBooks(){
        DB::table('books')->delete();

        factory(Book::class)->create([
            'title' => 'هملت',
            'price' => 20000,
            'author_id' => 2,
            'publisher_id' => 3,
            'warehouse_id' => 1,
            'quantity' => 25
        ]);

        factory(Book::class)->create([
            'title' => 'مکبث',
            'price' => 40000,
            'author_id' => 1,
            'publisher_id' => 2,
            'warehouse_id' => 1,
            'quantity' => 25
        ]);

        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $response = $this->getJson('api/books' , ['accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'title',
                        'price',
                        'rate',
                        'author',
                        'publisher',
                        'status'
                    ],
                    [
                        'id',
                        'title',
                        'price',
                        'rate',
                        'author',
                        'publisher',
                        'status'
                    ]
                ]

            ]);

    }


    public function testUpdateBooks(){
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $book = factory(Book::class)->create([
            'title' => 'لیرشاه',
            'price' => 20000,
            'author_id' => 2,
            'publisher_id' => 3,
            'warehouse_id' => 1,
            'quantity' => 25
        ]);

        $updateForm = [
            'title' => 'اتللو',
            'quantity' => 60

        ];

        $this->putJson( 'api/books/' . $book->id   , $updateForm , ['accept' => 'application/json'])
            ->assertStatus(200)
            ->assertSee('کتاب با موفقیت ویرایش شد.');

    }


    public function testDeleteBooks(){
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $book = factory(Book::class)->create([
            'title' => 'لیرشاه',
            'price' => 20000,
            'author_id' => 2,
            'publisher_id' => 3,
            'warehouse_id' => 1,
            'quantity' => 25
        ]);

        $this->deleteJson('api/books/' . $book->id )
            ->assertStatus(204);


    }

}
