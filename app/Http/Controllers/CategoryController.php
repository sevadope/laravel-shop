<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\FilterBoxRequest;
use App\Services\ProductService;
use App\Jobs\Cache\Category\CacheList;
use App\Cache\CacheManager;
use App\Services\CategoryService as Service;

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

        return view('public.categories.index', compact('categories'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, FilterBoxRequest $request, ProductService $p_service)
    {
        $products_query = $p_service->getQueryForCategoryDescendants($category);

        $this->filterQuery($products_query, $request->validated());

        $products = $products_query
            ->orderByPopularity()
            ->limit(self::PRODUCTS_LIST_SIZE)
            ->getForList();

        return view('public.categories.show', compact('category', 'products'));
    }

    protected function filterQuery(&$query, $data)
    {
        if (empty($data)) {
            return $query;
        }

        $data = array_filter($data, function ($item) {
            return !is_null($item);
        });

        $callbacks = $this->filterQueryCallbacks();

        foreach ($data as $key => $value) {
            $query = $callbacks[$key]($query, $value);
        }

        return $query;
    }

    protected function filterQueryCallbacks()
    {
        return [
            'min_price'=> function ($query, $value) {
                return $query->where('price', '>', $value);
            },
            'max_price'=> function ($query, $value) {
                return $query->where('price', '<', $value);
            },            
        ];
    }
}
