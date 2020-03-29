<?php

namespace App\Services;

use App\Cache\CacheManager;
use Illuminate\Contracts\Foundation\Application;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use App\Concerns\CanCacheActions;
use Illuminate\Http\UploadedFile;

class CategoryService
{
	public const IMAGE_WIDTH = 500;
	public const IMAGE_HEIGHT = 500;

	use CanCacheActions;

	public const IMAGES_PATH = 'categories/images';

	/**
	 * List of actions which support caching
	 *
	 * @var array
	 **/
	protected $cached_actions = [
		'getList',
		'get',
	];

	/**
	 * The application instance
	 * 
	 * @var \Illuminate\Contracts\Foundation\Application
	 **/
	private $app;

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function getList($list_size, $use_cache = true)
	{
		if ($use_cache && $this->cached(__FUNCTION__)) {
			$cache = $this->app->make(CacheManager::class);

			$keys = $cache->getFirstScoreValues(Category::CACHED_SCORE_NAME, $list_size);

			$categories = $cache->getArrayValues(Category::CACHED_LIST_NAME, $keys);

			return array_map(function ($item) {
				return unserialize($item);
			}, $categories);

		} else {
	        return Category::orderByPopularity()
	            ->paginate($list_size);
		}
		
	}

	public function get($key, $use_cache = true)
	{
		if ($use_cache && $this->cached(__FUNCTION__)) {
			$cache = $this->app->make(CacheManager::class);

			$fields = $cache->getAllArrayValues(Category::getCachePrefix().$key, $key);

			$category = (new Category)->buildFromCache($fields, $cache);

			return $category;

		} else {
			return Category::
				with('descendants', 'ancestors')
				->whereRouteKey($key)
				->first();
		}
	}

	public function createCategory(array $fields)
	{
		$fields['image'] = $this->storeImage($fields['image']);
		$fields = $this->fillNestedSetKeys($fields);

		$category = Category::create($fields);

		return $category;
	}	

	public function updateCategory(Category $category, array $fields)
	{
		if (isset($fields['image'])) {
			$fields['image'] = $this->storeImage($fields['image']);
			$this->removeImage($category->image);
		}

		return $category->update($fields);
	}

	protected function storeImage(
		UploadedFile $img,
		$path = self::IMAGES_PATH,
		$name = null,
		$disk = 'public'
	)
	{
		$name = $name ?? $img->hashName();

		$path = $img->storeAs($path, $name, $disk);
		$full_path = \Storage::disk($disk)->path($path);

		\Image::make($full_path)->fit(
			self::IMAGE_WIDTH,
			self::IMAGE_HEIGHT
		)->save();	

		return $path;
	}

	protected function removeImage(string $path)
	{
		return \Storage::delete($path);
	}

	protected function getCachedActions()
	{
		return $this->cached_actions;
	}

	protected function fillNestedSetKeys($fields, $parent_key = 'parent')
	{
		$parent = $this->get($fields[$parent_key], false);

		unset($fields[$parent_key]);

		$fields['tree_left_key'] = $parent->children->isEmpty() ?
			$parent->getTreeLeftKey() + 1
			: $parent
				->children
				->sortByDesc('tree_right_key')
				->first()
				->getTreeRightKey() + 1;

		$fields['tree_right_key'] = $fields['tree_left_key'] + 1;
		$fields['tree_depth'] = $parent->getTreeDepth() + 1;

		$query = Category::where('tree_left_key', '>=', $fields['tree_right_key']);

		$query->increment('tree_left_key', 2);
		$query->increment('tree_right_key', 2);

		$parent->increment('tree_right_key', 2);

		return $fields;
	}
}