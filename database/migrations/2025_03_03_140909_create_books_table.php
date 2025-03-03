<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id('book_id')->autoIncrement();
            $table->string('title', 255);
            $table->string('author', 255);
            $table->string('publisher', 255);
            $table->year('year');
            $table->string('isbn', 255);
            $table->integer('category_id');
            // $table->foreign('category_id')->references('category_id')->on('categories');
            $table->integer('stock')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
