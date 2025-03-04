<?php

namespace App\Services;

use App\Repository\CategoryRepository;
use Illuminate\Support\Facades\Validator;

use App\Helper\REST_Response;

class CategoryService {

    protected $repo;
    function __construct(CategoryRepository $repo) {
        $this->repo = $repo;
    }

    public function fetchAllCategories() {
        return $this->repo->get();
    }

    public function fetchCategoryById($id) {
        return $this->repo->find($id);
    }

    public function insertCategory($request) {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid category data',
                'errors' => $validator->errors()->all()
            ], REST_Response::BAD_REQUEST);
        }

        return $this->repo->insert($request->all());
    }

    public function updateCategory($request, $id) {
        $category = $this->repo->find($id);
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found',
                'errors' => null
            ], REST_Response::NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid category data',
                'errors' => $validator->errors()->all()
            ], REST_Response::BAD_REQUEST);
        }

        return $this->repo->update($request->all(), $id);
    }

    public function deleteCategory($id) {
        $category = $this->repo->find($id);
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found',
                'errors' => null
            ], REST_Response::NOT_FOUND);
        }

        return $this->repo->delete($id);
    }
}
