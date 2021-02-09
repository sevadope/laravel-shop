<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ProductsOption;
use App\Models\ProductsOptionsSet;
use App\Models\Category;
use Illuminate\Support\Collection;

class ProductSeeder extends Seeder
{
	public const PRODUCTS_COUNT = 1000;
    private const IMAGES_PATH = 'products/images';

    private const BRANDS = [
        'LG', 'Samsung', 'Asus',
        'Apple', 'Blackberry', 'ZTE',
        'Sony', 'Nokia', 'Huawei',
    ];

    private const TYPES = [
        ['Phone', 'Cell Phone', 'Smartphone'],
        ['Phone', 'Cell Phone', 'Smartphone'],
        ['Power Bank', 'Charge', 'Battery'],
        ['Battery'],
        ['Power Bank'],
        ['Battery', 'Charge'],
        ['USB Charge'],
        ['Headset', 'Headphones'],
        ['Bluetooth Headset', 'Bluetooth Headphones'],
        ['Wired Headset', 'Wired Headphones'],
        ['Case', 'Cover'],
        ['Charge', 'Cable'],
        ['Holder'],
        ['Tablet'],
        ['Tablet'],
        ['Tablet'],
        ['IPad'],
    ];

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
    		'slug' => Str::slug($name).Str::random(5),
    		'description' => str_repeat($name, 10),
            'popularity' => random_int(1, 1000),
            'price' => $this->getRandPrice(),
            'image' => $this->getRandImgPath(),
    	];
    }

    private function getLastCategoriesIDs()
    {
    	return [
    		2, 4, 5, 6, 7, 9, 10,
            11, 12, 13, 15,16, 17,
            19, 20, 21, 22, 23, 24,
            27, 28, 29, 30, 31, 33,
            34, 36, 37, 38,
    	];
    }

    private function getRandomCategory()
    {
    	return $this->categories->random();
    }

    private function generateNameByCategory($category)
    {
        $brand = self::BRANDS[array_rand(self::BRANDS)];
        $types = self::TYPES[$category->getKey() - 1];

        $model = strtoupper(Str::random(4));

        $type = $types[array_rand($types)];

        return "$brand $type $model";
    }

    private function getRandImgPath()
    {
        $imgs = $this->imgs ?? $this->imgs = Storage::files(self::IMAGES_PATH);

        return $imgs[array_rand($imgs)];
    }

    private function getRandPrice($precision = 2)
    {
        $mul = pow(10, $precision);
        $range = random_int(1, 4) == 4 ?
            [100, 300] : [10, 100];

        return random_int($range[0] * $mul, $range[1] * $mul) / $mul;
    }
}
