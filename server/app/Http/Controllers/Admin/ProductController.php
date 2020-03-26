<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
	private const PER_PAGE = 20;

    public function index()
    {
    	$products = Product::with('category')->orderByPopularity()->paginate(self::PER_PAGE);

    	return view('admin.products.index', compact('products'));
    }

    public function show($key)
    {
    	$product = Product::
    		with('specifications', 'options')
    		->whereRouteKey($key)
    		->first();

    	return view('admin.products.show', compact('product'));
    }
}
