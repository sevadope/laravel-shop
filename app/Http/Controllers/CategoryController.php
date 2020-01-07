<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private const LIST_SIZE = 10;
    private const PRODUCTS_LIST_SIZE = 10;

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
    public function show(Category $category)
    {
        if ($category->children()->count() === 0) {
            $products = Product::whereCategory($category->id);   
        } else {
            $products = Product::whereCategoryIn(
                $category->getAllChildren()
                    ->pluck($category->getKeyName())
                    ->toArray()
            );
        }

        $products = $products->orderByPopularity()
            ->limit(self::PRODUCTS_LIST_SIZE)
            ->getForList();

        return view('public.categories.show', compact('category', 'products'));
    }
}
