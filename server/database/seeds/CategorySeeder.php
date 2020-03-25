<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    private const IMAGES_PATH = 'categories/images';

    private $side_values = [];
    
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

        $this->side_values = $this->makeSideValues($categories_names);
    	$categories = $this->makeCategories($categories_names);

    	DB::table('categories')->insert($categories);
    }

    private function makeCategories(array $categories_names, $parent_id = null, $level = 0)
    {
    	$categories = [];

        $cur_id = $parent_id;
        $child_level = $level + 1;

    	foreach ($categories_names as $key => $value) {
    		if (is_array($value)) {

    			$categories[] = $this->makeCategory(++$cur_id, $key, $parent_id, $level);

    			$categories = array_merge(
    				$categories,
    				$this->{__FUNCTION__}($value, $cur_id, $child_level)
    			);

                $cur_id+= count($value, 1);
    		}
    		else {
    			$categories[] = $this->makeCategory(++$cur_id, $value, $parent_id, $level);
    		}
    	}
       
    	return $categories;
    }

    private function makeCategory($id, $name, $parent_id, $level)
    {
        $slug = Str::slug($name);
        $created_at = (string) now();

        $side_values = $this->side_values[$name];

    	return [
    		'name' => $name,
    		'slug' => $slug,
    		'description' => str_repeat($name.' - ', 10),
            'popularity' => random_int(1, 100),
            'image' => $this->getRandImgPath(),

            'tree_left_key' => $side_values['left'],
            'tree_right_key' => $side_values['right'],
            'tree_depth' => $side_values['depth'],

    		'created_at' => $created_at, 
    		'updated_at' => $created_at,
    	];
    }

    private function makeSideValues(array $categories, $left = 1, $depth = 0)
    {
        $paths = [];

        foreach ($categories as $key => $value) {
            if (is_array($value)) {
                $right = ($left + (2 * count($value, 1)) + 1);

                $paths[$key] = $this->makePath($left, $right, $depth);

                $paths = array_merge($paths, $this->{__FUNCTION__}($value, ++$left, $depth + 1));

                $left = $right + 1;

            } else {
                $paths[$value] = $this->makePath($left, ++$left, $depth);
                $left++;
            }
        }

        return $paths;
    }

    private function makePath($left, $right, $depth)
    {
        return [
            'left' => $left,
            'right' => $right,
            'depth' => $depth,
        ];
    }

    private function getRandImgPath()
    {
        $imgs = $this->imgs ?? $this->imgs = Storage::files(self::IMAGES_PATH);

        return $imgs[array_rand($imgs)];
    }
}
