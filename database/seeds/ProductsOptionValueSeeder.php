<?php

use Illuminate\Database\Seeder;
use App\Models\Product\Option;

class ProductsOptionValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$options = Option::all();

    	$values = [
    		1 => [	//color
    			'black',
    			'white',
    			'orange',
    			'red',
    			'blue',
    			'brown',
    			'green',
    		],
            2 => [  //capacity
                '6 gigabytes',
                '16 gigabytes',
                '32 gigabytes',
                '64 gigabytes',
                '128 gigabytes',
            ]
    	];

    	foreach ($values as $option_id => $option) {
    		DB::table('products_options_values')
    			->insert(array_map(function ($value) use ($option_id) {
    				return [
    					'value' => $value,
    					'option_id' => $option_id
    				];
    			}, $option)
    		);
    	}
    }
}
