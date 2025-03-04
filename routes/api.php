<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Api\BooksController;
use App\Http\Controllers\Api\CategoryController;

Route::prefix('v1')->middleware('api.guard')->group(function(){

    // auth
    Route::post('login', [LoginController::class, 'auth']);

    // group routes
    Route::prefix('books')->group(function(){
        // categories
        Route::get('categories', [CategoryController::class, 'index']);
        Route::get('categories/{id}', [CategoryController::class, 'show']);
        Route::post('categories', [CategoryController::class, 'store']);
        Route::put('categories/{id}', [CategoryController::class, 'update']);
        Route::delete('categories/{id}', [CategoryController::class, 'delete']);

        // books
        Route::get('', [BooksController::class, 'index']);
        Route::get('{id}', [BooksController::class, 'show']);
        Route::post('', [BooksController::class, 'store']);
        Route::put('{id}', [BooksController::class, 'update']);
        Route::delete('{id}', [BooksController::class, 'delete']);
    });

    // loans
    Route::prefix('loans')->group(function(){
        Route::post('create', [LoanController::class, 'createLoan']);
        Route::get('/', [LoanController::class, 'showAllLoans']);
        Route::get('{loan_id}', [LoanController::class, 'showLoanById']);

        Route::get('user/{user_id}', [LoanController::class, 'showLoanByUserId']);

        // Return book
        Route::post('return/{loan_id}', [LoanController::class, 'returnBook']);
    });
});
