<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $options  = [
        	[
        		1,
        		'string',
        		'color',
        	],
            [
                1,
                'string',
                'material',
            ],
        	[
        		2,
        		'string',
        		'body_size',
        	],
        	[
        		3,
        		'string',
        		'legs_size',
        	],
        	[
        		4,
        		'string',
        		'feet_size',
        	],
            [
                5,
                'string',
                'outerwear_size',
            ],
        ];

        DB::table('products_options')->insert(array_map(function ($option) {
            return [
                'set_id' => $option[0],
                'data_type' => $option[1],
                'name' => $option[2],
            ];
        }, $options));
    }
}
