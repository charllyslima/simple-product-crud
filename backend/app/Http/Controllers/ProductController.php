<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProductController extends BaseController
{
    public function index(Request $request): JsonResponse
    {

        $cacheKey = 'products_page_' . $request->query('page', 1) . '_category_' . $request->query('category_id', 'all');

        $products = Cache::remember($cacheKey, 60 * 60 * 24, function () use ($request) {
            $query = Product::query();

            if ($request->has('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            return $query->paginate(10);
        });

        return $this->sendResponse($products, 'Produtos recuperados com sucesso.');
    }

    public function store(CreateProductRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (!empty($data['picture'])) {
            $picture = $data['picture'];

            $image = explode(';base64,', $picture);
            if (count($image) == 2) {
                $image_type_aux = explode('image/', $image[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image[1]);

                $file_name = 'product_' . time() . '.' . $image_type; // Nome do arquivo com timestamp

                Storage::disk('private')->put('pictures/' . $file_name, $image_base64);

                $data['picture'] = $file_name;
            } else {
                unset($data['picture']);
            }
        }

        $product = Product::create($data);

        Cache::tags('products')->flush();

        // Retornar uma resposta JSON
        return $this->sendResponse($product, 'Produto criado com sucesso.');
    }

    public function show(Product $product): JsonResponse
    {
        $cacheKey = 'product_' . $product->id;

        $product = Cache::remember($cacheKey, 60 * 60 * 24, function () use ($product) {
            return $product;
        });

        return $this->sendResponse($product, 'Produto recuperado com sucesso.');
    }

    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();

        if (!empty($data['picture'])) {
            $picture = $data['picture'];

            $image = explode(';base64,', $picture);
            if (count($image) == 2) {
                $image_type_aux = explode('image/', $image[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image[1]);

                if ($product->picture) {
                    Storage::disk('private')->delete($product->picture);
                }

                $file_name = 'product_' . time() . '.' . $image_type; // Nome do arquivo com timestamp

                Storage::disk('private')->put('pictures/' . $file_name, $image_base64);

                $data['picture'] = $file_name;
            } else {
                unset($data['picture']);
            }
        } else {
            unset($data['picture']);
        }

        $product->update($data);

        Cache::tags('products')->flush();
        Cache::forget('product_' . $product->id);

        return $this->sendResponse($product, 'Produto atualizado com sucesso.');
    }


    public function destroy(Product $product): JsonResponse
    {
        if ($product->picture) {
            Storage::disk('private')->delete($product->picture);
        }
        $product->delete();

        Cache::tags('products')->flush();
        Cache::forget('product_' . $product->id);

        return $this->sendResponse(null, 'Produto excluído com sucesso.');
    }
}
