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

class CategoryController extends Controller
{
    private const LIST_SIZE = 30;
    private const PRODUCTS_LIST_SIZE = 50;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Service $service)
    {
        $categories = $service->getList(self::LIST_SIZE);

        return CategoryResource::collection($categories);
    }
}
