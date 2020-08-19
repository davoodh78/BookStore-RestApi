<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title',50);
            $table->integer('price');
            $table->foreignId("author_id")
                ->references("id")
                ->on('authors')
                ->onDelete("cascade");
            $table->foreignId("publisher_id")
                ->references("id")
                ->on("publishers")
                ->onDelete("cascade");
            $table->foreignId("warehouse_id")
                ->references("id")
                ->on("warehouses")
                ->onDelete("cascade");
            $table->smallInteger('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
