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
    	];

    	foreach ($values as $option_id => $option) {
    		DB::table('products_options_values')
    			->insert(array_map(function ($value) use ($option_id) {
    				return [
    					'name' => $value,
    					'option_id' => $option_id
    				];
    			}, $option)
    		);
    	}
    }
}
