<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;

class ProductService
{
	public function getQueryForCategoryDescendants(Category $category)
	{
		if ($category->hasDescendants()) {
			$products = Product::whereCategoriesIn(
				$category->descendants()
					->getQuery()
					->pluck($category->getKeyName())
			);
		} else {
			$products = Product::whereCategory($category->getKey());
		}

		return $products;
	}
}