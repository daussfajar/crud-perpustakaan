<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Books;
use App\Models\Categories;

class BooksController extends Controller
{
    function __construct()
    {

    }

    public function index(){
        $books = Books::all();
        return response()->json([
            'status' => 'success',
            'data' => $books,
        ], 200);
    }

    public function get(int $id){
        $book = Books::where('book_id', $id)->first();
        if(!$book){
            return response()->json([
                'status' => 'error',
                'message' => 'Book not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $book,
        ], 200);
    }

    public function getCategories(){
        $categories = Categories::all();
        return response()->json([
            'status' => 'success',
            'data' => $categories,
        ], 200);
    }
}
