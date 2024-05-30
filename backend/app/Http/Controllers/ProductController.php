<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends BaseController
{
    public function index(Request $request): JsonResponse
    {
        $query = Product::query();

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(10);
        return $this->sendResponse($products, 'Produtos recuperados com sucesso.');
    }

    public function store(CreateProductRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('picture') && $request->file('picture')) {
            $file = $request->file('picture');
            if ($file->isValid()) {
                $data['picture'] = basename($file->store('pictures', 'private'));
            }
        }

        $product = Product::create($data);
        return $this->sendResponse($product, 'Produto criado com sucesso.');
    }

    public function show(Product $product): JsonResponse
    {
        return $this->sendResponse($product, 'Produto recuperado com sucesso.');
    }

    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('picture')) {
            // Delete old picture if exists
            if ($product->picture) {
                Storage::disk('private')->delete($product->picture);
            }
            $file = $request->file('picture');
            if ($file->isValid()) {
                $data['picture'] = basename($file->store('pictures', 'private'));
            }
        }

        $product->update($data);
        return $this->sendResponse($product, 'Produto atualizado com sucesso.');
    }

    public function destroy(Product $product): JsonResponse
    {
        if ($product->picture) {
            Storage::disk('private')->delete($product->picture);
        }
        $product->delete();
        return $this->sendResponse(null, 'Produto excluído com sucesso.');
    }
}
