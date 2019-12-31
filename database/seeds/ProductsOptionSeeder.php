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
        		'type_id' => 1,
        		'data_type' => 'string',
        		'name' => 'color',
        	],
            [
                'type_id' => 1,
                'data_type' => 'string',
                'name' => 'material',
            ],
        	[
        		'type_id' => 2,
        		'data_type' => 'string',
        		'name' => 'body_size',
        	],
        	[
        		'type_id' => 3,
        		'data_type' => 'string',
        		'name' => 'legs_size',
        	],
        	[
        		'type_id' => 4,
        		'data_type' => 'string',
        		'name' => 'feet_size',
        	],
            [
                'type_id' => 5,
                'data_type' => 'string',
                'name' => 'outerwear_size',
            ],
        ];

        DB::table('products_options')->insert($options);
    }
}
