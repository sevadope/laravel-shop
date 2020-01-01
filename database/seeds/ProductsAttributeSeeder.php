<?php

use Illuminate\Database\Seeder;

class ProductsAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attributes = [
            [
                1,
                'string',
                'material',
            ],
        	[
        		1,
        		'string',
        		'color',
        	],
        ];


        DB::table('products_attributes')->insert(array_map(function ($attr) {
        	return [
    			'preset_id' => $attr[0],
    			'data_type' => $attr[1],
    			'name' => $attr[2],        		
        	];
        }, $attributes));
    }
}
