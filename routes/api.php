<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Api\BooksController;

Route::prefix('v1')->group(function(){
    Route::post('login', [LoginController::class, 'auth']);
    Route::get('books', [BooksController::class, 'index']);
    Route::get('books/{id}', [BooksController::class, 'get']);
    Route::get('books/categories', [BooksController::class, 'getCategories']);

    Route::post('loan', [LoanController::class, 'loanBook']);
    Route::post('return', [LoanController::class, 'returnBook']);

    // show loans
    Route::get('loans', [LoanController::class, 'index']);
    Route::get('loans/{id}', [LoanController::class, 'get']);

    // show returns
    Route::get('returns', [LoanController::class, 'returns']);
    Route::get('returns/{id}', [LoanController::class, 'getReturn']);
});
