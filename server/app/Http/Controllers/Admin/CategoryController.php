<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;

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
