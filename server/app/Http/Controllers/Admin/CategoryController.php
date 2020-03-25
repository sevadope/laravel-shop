<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Requests\CreateCategoryRequest;
use App\Services\CategoryService;
use App\Services\ProductService;

class CategoryController extends Controller
{
	private const PER_PAGE = 20;
	private const PRODUCTS_LIST_SIZE = 20;

	public function index(CategoryService $service)
	{
		$categories = $service->getList(self::PER_PAGE, false);

		return view('admin.categories.index', compact('categories'));
	}

	public function show(
		$key,
		CategoryService $service,
		ProductService $p_service
	)
	{
		$category = $service->get($key, false);

		$query = $p_service->getQueryForCategoryDescendants($category);

        $products = $query
            ->orderByPopularity()
            ->limit(self::PRODUCTS_LIST_SIZE)
            ->getForList();

		return view('admin.categories.show', compact('category', 'products'));
	}

	public function create()
	{
		$categories = Category::get();

		return view('admin.categories.create', compact('categories'));
	}

	public function store(
		CreateCategoryRequest $request,
		CategoryService $service
	)
	{
		$data = $request->validated();

		$category = $service->createCategory($data);

		return $category ?
			redirect()
				->route('admin.categories.show', $category->getRouteKey())
				->with(['msg' => 'Category created.'])
			: back()
				->withErrors(['msg' => 'Category creation error. Please try again.'])
				->withInput();
	}

	public function edit(Category $category)
	{
		return view('admin.categories.edit', compact('category'));
	}

	public function update(
		UpdateCategoryRequest $req,
		CategoryService $service,
		Category $category
	)
	{
		$data = $req->validated();

		$success = $service->updateCategory($category, $data);

		return $success ? 
			redirect()
				->route('admin.categories.show', $category->getRouteKey())
				->with(['msg' => "Category $category->name updated."])
			: back()
				->withErrors(['msg' => 'Update error. Please try again.'])
				->withInput();
	}

	public function delete(Category $category)
	{
		$deleted = $category->delete();

		return $deleted ?
			redirect()
				->route('admin.categories.index')
				->with(['msg' => 'Category deleted.'])
			: back()
				->withErrors(['msg' => 'Delete error. Please try again.']);
	}
}
