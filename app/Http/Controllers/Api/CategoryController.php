<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $service;

    function __construct(CategoryService $service){
        $this->service = $service;
    }

    public function index(){
        return $this->service->fetchAllCategories();
    }

    public function show($id){
        return $this->service->fetchCategoryById($id);
    }

    public function store(Request $request){
        return $this->service->insertCategory($request);
    }

    public function update(Request $request, $id){
        return $this->service->updateCategory($request, $id);
    }

    public function delete($id){
        return $this->service->deleteCategory($id);
    }

}
