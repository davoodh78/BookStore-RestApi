<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use phpseclib\Crypt\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('authors')->insert([
            [
                "firstname" => "فئودور",
                "lastname" => "داستایوفسکی"
            ],
            [
                "firstname" => "لئو",
                "lastname" => "تولستوی"
            ],
            [
                "firstname" => "صادق",
                "lastname" => "هدایت"
            ],
            [
                "firstname" => "بزرگ",
                "lastname" => "علوی"
            ],
            [
                "firstname" => "محمود",
                "lastname" => "دولت آبادی"
            ]
        ]);

        DB::table("publishers")->insert([
            [
                "name" => "نشر چشمه"
            ],
            [
                "name" => "نشر نگاه"
            ],
            [
                "name" => "نشر امیرکبیر"
            ],
        ]);
        DB::table('warehouses')->insert([
            'name'=>"انبار 1"
        ]);

        DB::table('books')->insert([
            [
                "title" => 'ابله',
                'price' => 50000,
                'publisher_id'=>2,
                'author_id'=> 1,
                "warehouse_id" => 1,
                "quantity" => 40

            ],[
                "title" => 'آناکارنینا',
                'price' => 80000,
                'publisher_id'=>1,
                'author_id'=> 2,
                "warehouse_id" => 1,
                "quantity" => 10

            ],[
                "title" => 'بوف کور',
                'price' => 30000,
                'publisher_id'=>3,
                'author_id'=> 3,
                "warehouse_id" => 1,
                "quantity" => 30

            ],[
                'title' => 'چشم‌هایش',
                'price' => 40000,
                'publisher_id'=>1,
                'author_id'=> 4,
                "warehouse_id" => 1,
                "quantity" => 25

            ],[
                "title" => 'کلیدر',
                'price' => 50000,
                'publisher_id'=>2,
                'author_id'=> 5,
                'warehouse_id' => 1,
                'quantity' => 20

            ]

        ]);
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => \Illuminate\Support\Facades\Hash::make('12345678')
        ]);
    }
}
