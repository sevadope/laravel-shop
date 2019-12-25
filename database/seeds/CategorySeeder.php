<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories_names = [
            'Men' => [
                'Clothing' => [
                    'Activewear' => [
                        'Shorts',
                        'Tops',
                        'Running',
                        'Gym & Training',   
                    ],
                    'Hoodies & Sweatshirts' => [
                        'Sweatshirts',
                        'Zip hoodies',
                        'Hoodies',
                    ],
                    'Jackets & Coats' => [
                        'Leather jackets',
                        'Trench coats',
                        'Denim jackets',
                        'Parkas',
                    ],
                    'Jeans' => [
                        'Skinny jeans',
                        'Slim jeans',
                        'Straight jeans',
                        'Tapered jeans',
                    ],
                    'Shorts' => [
                        'Cargo shorts',
                        'Chino shorts',
                        'Denim shorts',
                        'Tailored shorts',
                    ],
                    'Shirts' => [
                        'Check shirts',
                        'Denim shirts',
                        'Short sleeve shirts',
                        'Printed shirts',
                    ],
                ],

                'Shoes' => [
                    'Boots',
                    'Shoes',
                    'Sneakers', 
                ],
                'Accessories' => [
                    'Bags',
                    'Belts',
                    'Caps & Hats',
                    'Gloves',
                ],
            ],
            'Women' => [
                'Clothing' => [
                    'Coats & Jackets' => [
                        'Coats',
                        'Jackets',
                        'Leather jackets',
                        'Trench',
                    ],
                    'Dresses' => [
                        'Evening dresses',
                        'Dresses for weddings',
                        'Maxi dresses',
                    ],
                    'Hoodies & Sweatshirts' => [
                        'Hoodies',
                        'Sweatshirts',
                    ],
                    'Jeans' => [
                        'Skinny jeans',
                        'Boyfriend jeans',
                        'Slim jeans',
                        'Jeggings',
                    ],
                    'Jumpsuits & Rompers' => [
                        'Boiler suits',
                        'Jumpsuits',
                        'Rompers',
                    ],
                    'Skirts' => [
                        'Midi skirts',
                        'Mini skirts',
                        'Pencil skirts',
                        'Denim skirts',
                    ],
                ],
                'Shoes' => [
                    'Boots',
                    'Flat sandals',
                    'Flat shoes',
                    'Heels',
                ],
                'Accessories' => [
                    'Bags',
                    'Belts',
                    'Hair accessories',
                    'Hats',
                ],
            ],
        ];

    	$categories = $this->makeCategories($categories_names);
    	info($categories);
    	DB::table('categories')->insert($categories);
    }

    private function makeCategories(array $categories_names, $parent_path = null)
    {
    	$categories = [];

    	foreach ($categories_names as $key => $value) {
    		if (is_array($value)) {

                $cur_path = $this->makePath($parent_path, $key);
    			$categories[] = $this->makeCategory($key, $cur_path);

    			$categories = array_merge(
    				$categories,
    				$this->{__FUNCTION__}($value, $cur_path)
    			);
    		}
    		else {
                $cur_path = $this->makePath($parent_path, $value);
    			$categories[] = $this->makeCategory($value, $cur_path);
    		}
    		
    	}

    	return $categories;
    }

    private function makeCategory($name, string $cur_path)
    {
        $slug = Str::slug($name);
        $created_at = (string) now();

    	return [
    		'path' => $cur_path,
    		'name' => $name,
    		'slug' => $slug,
    		'description' => str_repeat($name.' - ', 10),
    		'created_at' => $created_at, 
    		'updated_at' => $created_at,
    	];
    }

    private function makePath($parent_path, $name)
    {
        $cur_path = str_replace('-', '_', ucfirst(Str::slug($name)));

        return $parent_path ? $parent_path.'.'.$cur_path : $cur_path;
    }
}
