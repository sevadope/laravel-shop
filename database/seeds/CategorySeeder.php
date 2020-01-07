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
            'Mobile Phones' => [
                'Cell Phones',
                'Batteries, Power Banks & Chargers' => [
                    'Cell Phone Batteries',
                    'Power Banks',
                    'Standard Batteries & Chargers',
                    'USB Chargers',
                ],
                'Headsets & Accessories' => [
                    'Bluetooth Headsets & Accessories',
                    'Wired Headsets & Accessories',
                ],
                'Cases & Covers',
                'Chargers & Cables',
                'Mounts & Holders',
            ],

            'Tablets' => [
                'Android Tablets',
                'Window Tablets',
                'iPad',
            ],
            'TV & Home Theater' => [
                'TV & Video',
                'Home Audio & Home Theater',
                'Home Video Accessories',
                'Audio / Video Cables',
                'HDMI Cables',
                'TV Mounts',
            ],
            'Portable Electronics' => [
                'Headphones & Accessories' => [
                    'Headphones',
                    'Headphone Accessories'
                ],
                'Portable Speakers',
                'Gadgets & Wearables',
                'Portable Electronic Devices',
                'Digital Cameras & Accessories' => [
                    'Digital Cameras',
                    'Digital Camera Accessories',
                ],
            ],
            'Speciality Electronics' => [
                'Drones',
                'Musical Instruments',
                'Alternative Energy',
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
            'popularity' => random_int(1, 100),
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
