<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function index(Request $request): JsonResponse
    {
        $categories = Category::paginate(10);
        return $this->sendResponse($categories, 'Categories retrieved successfully.');
    }

    public function store(CreateCategoryRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());
        return $this->sendResponse($category, 'Category created successfully.');
    }

    public function show(Category $category): JsonResponse
    {
        return $this->sendResponse($category, 'Category retrieved successfully.');
    }

    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $category->update($request->validated());
        return $this->sendResponse($category, 'Category updated successfully.');
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();
        return $this->sendResponse(null, 'Category deleted successfully.');
    }
}
