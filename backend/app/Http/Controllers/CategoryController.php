<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends BaseController
{
    public function index(Request $request): JsonResponse
    {
        $cacheKey = 'categories_page_' . $request->query('page', 1);

        $categories = Cache::remember($cacheKey, 60 * 60 * 24, function() {
            return Category::paginate(10);
        });

        return $this->sendResponse($categories, 'Categorias recuperadas com sucesso.');
    }

    public function store(CreateCategoryRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());

        Cache::tags('categories')->flush();

        return $this->sendResponse($category, 'Categoria criada com sucesso.');
    }

    public function show(Category $category): JsonResponse
    {
        $cacheKey = 'category_' . $category->id;

        $category = Cache::remember($cacheKey, 60 * 60 * 24, function() use ($category) {
            return $category;
        });

        return $this->sendResponse($category, 'Categoria recuperada com sucesso.');
    }

    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $category->update($request->validated());

        Cache::tags('categories')->flush();
        Cache::forget('category_' . $category->id);

        return $this->sendResponse($category, 'Categoria atualizada com sucesso.');
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        Cache::tags('categories')->flush();
        Cache::forget('category_' . $category->id);

        return $this->sendResponse(null, 'Categoria excluída com sucesso.');
    }

    public function search(string $keyword): JsonResponse
    {
        if ($keyword !== 'all') {
            $cacheKey = 'categories_search_' . $keyword;
            $categories = Cache::remember($cacheKey, 60 * 60, function() use ($keyword) {
                return Category::where('name', 'like', '%' . $keyword . '%')->get();
            });
        } else {
            $cacheKey = 'categories_all';
            $categories = Cache::remember($cacheKey, 60 * 60, function() {
                return Category::all();
            });
        }

        return $this->sendResponse(Category::all(), 'Resultados da busca recuperados com sucesso.');

    }
}
