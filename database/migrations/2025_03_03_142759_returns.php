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
        Schema::create('returns', function (Blueprint $table) {
            $table->id('return_id')->autoIncrement();
            $table->unsignedBigInteger('loan_id');
            $table->date('return_date');
            $table->enum('status', ['fine', 'good']);
            $table->timestamps();

            $table->foreign('loan_id')->references('loan_id')->on('loans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
