<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Services\BookService;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    protected $service;

    function __construct(BookService $service){
        $this->service = $service;
    }

    public function index(){
        return $this->service->fetchAllBooks();
    }

    public function show($id){
        return $this->service->fetchBookById($id);
    }

    public function store(Request $request){
        return $this->service->insertBook([
            'title'         => $request->input('title'),
            'author'        => $request->input('author'),
            'publisher'     => $request->input('publisher'),
            'year'          => $request->input('year'),
            'isbn'          => $request->input('isbn'),
            'stock'         => $request->input('stock'),
            'category_id'   => $request->input('category_id')
        ]);
    }

    public function update($id, Request $request){
        return $this->service->updateBook([
            'title'         => $request->input('title'),
            'author'        => $request->input('author'),
            'publisher'     => $request->input('publisher'),
            'year'          => $request->input('year'),
            'isbn'          => $request->input('isbn'),
            'stock'         => $request->input('stock'),
            'category_id'   => $request->input('category_id')
        ], $id);
    }

    public function delete($id){
        return $this->service->deleteBook($id);
    }
}
