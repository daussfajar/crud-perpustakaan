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
        Schema::create('loans', function (Blueprint $table) {
            $table->id('loan_id')->autoIncrement();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('book_id');
            $table->date('loan_date');
            $table->date('return_date');
            $table->enum('status', ['borrowed', 'returned', 'late']);
            $table->timestamps();
            // $table->foreign('user_id')->references('user_id')->on('users');
            // $table->foreign('book_id')->references('book_id')->on('books');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
