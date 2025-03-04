<?php

namespace App\Services;

use App\Repository\BooksRepository;
use Illuminate\Support\Facades\Validator;

use App\Helper\REST_Response;

class BookService {

    protected $repo;
    function __construct(BooksRepository $repo) {
        $this->repo = $repo;
    }

    public function fetchAllBooks() {
        return $this->repo->get();
    }

    public function fetchBookById($id) {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid book id',
                'errors' => $validator->errors()->all()
            ], REST_Response::BAD_REQUEST);
        }

        return $this->repo->find($id);
    }

    public function insertBook(array $data) {
        $validator = Validator::make($data, [
            'title'         => 'required|string',
            'author'        => 'required|string',
            'publisher'     => 'required|string',
            'year'          => 'required|integer',
            'isbn'          => 'required|string',
            'stock'         => 'required|integer',
            'category_id'   => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid book data',
                'errors' => $validator->errors()->all()
            ], REST_Response::BAD_REQUEST);
        }

        return $this->repo->insert($data);
    }

    public function updateBook(array $data, $id) {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid book id',
                'errors' => $validator->errors()->all()
            ], REST_Response::BAD_REQUEST);
        }

        // check book exists
        $book = $this->repo->find($id);
        if (!$book) {
            return response()->json([
                'status' => 'error',
                'message' => 'Book not found',
                'errors' => null
            ], REST_Response::NOT_FOUND);
        }

        $validator = Validator::make($data, [
            'title'         => 'required|string',
            'author'        => 'required|string',
            'publisher'     => 'required|string',
            'year'          => 'required|integer',
            'isbn'          => 'required|string',
            'stock'         => 'required|integer',
            'category_id'   => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid book data',
                'errors' => $validator->errors()->all()
            ], REST_Response::BAD_REQUEST);
        }

        return $this->repo->update($data, $id);
    }

    public function deleteBook($id) {
        $book = $this->repo->find($id);
        if (!$book) {
            return response()->json([
                'status' => 'error',
                'message' => 'Book not found',
                'errors' => null
            ], REST_Response::NOT_FOUND);
        }

        return $this->repo->delete($id);
    }
}
