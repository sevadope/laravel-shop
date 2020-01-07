<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private const LIST_SIZE = 30;
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
    public function show($slug)
    {
        $category = Category::whereSlug($slug)->first();

        if ($category->hasChildren()) {
            $products = Product::whereCategoriesIn(
                $category->descendants
                    ->pluck($category->getKeyName())
                    ->toArray()
            );
        } else {
            $products = Product::whereCategory($category->id);   
        }

        $products = $products->orderByPopularity()
            ->limit(self::PRODUCTS_LIST_SIZE)
            ->getForList();

        return view('public.categories.show', compact('category', 'products'));
    }
}
