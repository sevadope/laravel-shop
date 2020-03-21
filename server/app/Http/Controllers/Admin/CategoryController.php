<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
	private const PER_PAGE = 20;

	public function index()
	{
		$categories = Category::orderByPopularity(false)->paginate(self::PER_PAGE);

		return view('admin.categories.index', compact('categories'));
	}

	public function show(Category $category)
	{
		return view('admin.categories.show', compact('category'));
	}
}
