<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\FilterBoxRequest;

class CategoryController extends Controller
{
    private const LIST_SIZE = 30;
    private const PRODUCTS_LIST_SIZE = 50;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderByPopularity()
            ->limit(self::LIST_SIZE)
            ->get();

        return view('public.categories.index', compact('categories'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, FilterBoxRequest $request)
    {
        if ($category->hasChildren()) {
            $products = Product::whereCategoriesIn(
                $category->descendants
                    ->pluck($category->getKeyName())
                    ->toArray()
            );
        } else {
            $products = Product::whereCategory($category->id);   
        }

        $products = $this->filterQuery($products, $request->validated());

        $products = $products->orderByPopularity()
            ->limit(self::PRODUCTS_LIST_SIZE)
            ->getForList();

        return view('public.categories.show', compact('category', 'products'));
    }

    protected function filterQuery($query, $data)
    {
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
