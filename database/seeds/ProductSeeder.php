<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ProductsOption;
use App\Models\ProductsOptionsSet;
use App\Models\Category;
use Illuminate\Support\Collection;

class ProductSeeder extends Seeder
{
	public const PRODUCTS_COUNT = 100;


	private $options;
	private $categories;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->categories = Category::
    		whereIn('id', $this->getLastCategoriesIDs())
    		->get();

    	$products = [];

    	for ($i=0; $i < self::PRODUCTS_COUNT; $i++) { 

    		$cur_category = $this->getRandomCategory();

    		$products[] = $this->makeProduct(
    			$cur_category->getKey(),
    			$this->generateNameByCategory($cur_category),
    		);
    	}


    	DB::table('products')->insert($products);
    }

    private function makeProduct(
    	int $category_id,
    	string $name
    )
    {
    	return [
    		'category_id' => $category_id,
    		'name' => $name,
    		'slug' => Str::slug($name),
    		'description' => str_repeat($name, 10),
    	];
    }

    private function getLastCategoriesIDs()
    {
    	return [ 
    		4, 5, 6, 7,
    		9, 10, 11, 
    		13, 14, 15, 16,
    		18, 19, 20, 21,
    		23, 24, 25, 26,
    		28, 29, 30, 31,
    		33, 34, 35,

    		44, 45, 46, 47,
    		49, 50, 51,
    		53, 54,
    		56, 57, 58, 59,
    		61, 62, 63,
    		65, 66, 67, 68,
    		70, 71, 72, 73,
    	];
    }

    private function getRandomCategory()
    {
    	return $this->categories->random();
    }

    private function generateNameByCategory($category)
    {
    	$category_name = $category->name;

    	$name = $category_name[-1] == 's' ? 
    		str_split($category_name, strlen($category_name) - 1)[0]
    		: $category_name;

    	$name .= ' ' . random_int(1, 1000000);

    	return $name; 
    }
}
