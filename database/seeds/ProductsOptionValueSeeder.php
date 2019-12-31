<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ProductsOption;

class ProductsOptionValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$options = ProductsOption::all();

    	$values = [
    		2 => [	//material
    			'95% cotton 5% elasthane',
    			'100% cotton',
    			'80% cotton 20% elasthane',
    			"top fabric: 100% nylon \n
    			lining: 100% polyamide",
    			'98% cotton 2% elasthane',
    			"Upper: Synthetic Leather/Mesh;\n
    			Outsole: Molding EVA/RB",
    		],
    		1 => [	//color
    			'black',
    			'white',
    			'orange',
    			'red',
    			'blue',
    			'brown',
    			'green',
    		],
    		3 => [	//body_size
    			'S',
    			'M',
    			'L',
    			'XL'
    		],
    		6 => [ //outerwear_size
    			'170-175',
    			'175-180',
    			'180-185',
    			'185-190',
    			'190-195',
    			'195-200',
    		],
    		4 => [	//legs_size
    			'170',
    			'175',
    			'180',
    			'185',
    			'190',
    			'195',
    			'200',
    		],
    		5 => [	//feet_size
    			'7',
    			'7.5',
    			'8',
    			'8.5',
    			'9',
    			'9.5',
    			'10',
    			'10.5',
    			'11',
    			'11.5',
    			'12',
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
