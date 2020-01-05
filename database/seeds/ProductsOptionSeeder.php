<?php

use Illuminate\Database\Seeder;

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
        		'string',
        		'color',
        	],
        	[

        		'string',
        		'body_size',
        	],
        	[

        		'string',
        		'legs_size',
        	],
        	[

        		'string',
        		'feet_size',
        	],
            [

                'string',
                'outerwear_size',
            ],
        ];

        DB::table('products_options')->insert(array_map(function ($option) {
            return [
                'data_type' => $option[0],
                'name' => $option[1],
            ];
        }, $options));
    }
}
