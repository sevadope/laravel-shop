<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FilterBoxRequest;
use App\Services\ProductService;
use App\Jobs\Cache\Category\CacheList;
use App\Cache\CacheManager;
use App\Services\CategoryService as Service;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\ProductCollection;

class CategoryController extends Controller
{
    private const LIST_SIZE = 30;
    private const PRODUCTS_LIST_SIZE = 50;

    /**
     * Get a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Service $service)
    {
        $categories = $service->getList(self::LIST_SIZE);

        return new CategoryCollection($categories);
    }

    /**
     * Get the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($key, Service $service)
    {
        $category = $service->get($key);

        return new CategoryResource($category);
    }

    /**
     * Get products for category
     **/
    public function products(
        $key,
        Service $service,
        ProductService $p_service
    )
    {
        $category = $service->get($key);

        $products_query = $p_service->getQueryForCategoryDescendants($category);

        $products = $products_query
            ->orderByPopularity()
            ->limit(self::PRODUCTS_LIST_SIZE)
            ->getForList();

        return new ProductCollection($products);
    }
}
