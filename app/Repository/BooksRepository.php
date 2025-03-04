<?php

namespace App\Repository;

use App\Models\Books;
use Illuminate\Http\JsonResponse;
use App\Helper\REST_Response;

class BooksRepository
{
    public function get() : JsonResponse
    {
        $books = Books::with('category:category_id,category_name')
            ->select('book_id', 'title', 'author', 'publisher', 'year', 'isbn', 'stock', 'category_id')
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Books fetched successfully',
            'data' => $books
        ], REST_Response::SUCCESS);
    }

    public function find($id) : JsonResponse
    {
        $book = Books::with('category:category_id,category_name')
            ->select('book_id', 'title', 'author', 'publisher', 'year', 'isbn', 'stock', 'category_id')
            ->where('book_id', $id)
            ->first();

        if (!$book) {
            return response()->json([
                'status' => 'error',
                'message' => 'Book not found',
                'errors' => null
            ], REST_Response::NOT_FOUND);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Book fetched successfully',
            'data' => $book
        ], REST_Response::SUCCESS);
    }

    public function update(array $data, $id) : JsonResponse
    {
        $book = Books::where('book_id', $id);
        $check = $book->first();

        if (!$check) {
            return response()->json([
                'status' => 'error',
                'message' => 'Book not found',
                'errors' => null
            ], REST_Response::NOT_FOUND);
        }

        $book->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Book updated successfully',
            'data' => [
                'book_id' => $id,
                'title' => $data['title'],
                'author' => $data['author'],
                'publisher' => $data['publisher'],
                'year' => $data['year'],
                'isbn' => $data['isbn'],
                'stock' => $data['stock'],
                'category_id' => $data['category_id']
            ]
        ], REST_Response::SUCCESS);
    }

    public function insert(array $data) : JsonResponse
    {
        $book = new Books();
        $book->title = $data['title'];
        $book->author = $data['author'];
        $book->publisher = $data['publisher'];
        $book->year = $data['year'];
        $book->isbn = $data['isbn'];
        $book->stock = $data['stock'];
        $book->category_id = $data['category_id'];

        $book->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Book inserted successfully',
            'data' => $book
        ], REST_Response::CREATED);
    }

    public function delete($id) : JsonResponse
    {
        $book   = Books::where('book_id', $id);
        $check  = $book->first();

        if (!$check) {
            return response()->json([
                'status' => 'error',
                'message' => 'Book not found',
                'errors' => null
            ], REST_Response::NOT_FOUND);
        }

        $book->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Book deleted successfully',
            'data' => [
                'book_id' => $id
            ]
        ], REST_Response::SUCCESS);
    }

    public function isBookAvailable($id) : bool
    {
        $book = Books::where('book_id', $id)->first();

        if (!$book) {
            return false;
        }

        return $book->stock > 0;
    }
}
