<?php

namespace App\Repository;

use App\Models\Categories;
use Illuminate\Http\JsonResponse;
use App\Helper\REST_Response;

class CategoryRepository
{
    public function get() : JsonResponse
    {
        $categories = Categories::select('category_id', 'category_name')
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Categories fetched successfully',
            'data' => $categories
        ], REST_Response::SUCCESS);
    }

    public function find($id) : JsonResponse
    {
        $category = Categories::select('category_id', 'category_name')
            ->where('category_id', $id)
            ->first();

        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found',
                'data' => null
            ], REST_Response::NOT_FOUND);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Category fetched successfully',
            'data' => $category
        ], REST_Response::SUCCESS);
    }

    public function insert(array $data) : JsonResponse
    {
        $category = Categories::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Category inserted successfully',
            'data' => $category
        ], REST_Response::CREATED);
    }

    public function update(array $data, $id) : JsonResponse
    {
        $category = Categories::where('category_id', $id);
        $check = $category->first();

        if(!$check) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found',
            ], REST_Response::NOT_FOUND);
        }

        $category->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully',
            'data' => [
                'category_id' => $id
            ]
        ], REST_Response::SUCCESS);
    }

    public function delete($id) : JsonResponse
    {
        $category = Categories::where('category_id', $id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully',
            'data' => [
                'category_id' => $id
            ]
        ], REST_Response::SUCCESS);
    }
}
