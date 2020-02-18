<?php

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsSpecificationValueSeeder extends Seeder
{
    private const SPECS_PER_PRODUCT_RANGE = [2, 5];

    private $products = [];
    private $specifications;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->products = Product::get();

        $this->specifications = [
            1 => [  //color
                'black',
                'white',
                'orange',
                'red',
                'blue',
                'brown',
                'green',
            ],
            2 => [  //height
                '10 inches',
                '20 inches',
                '5 inches',
            ], 
            3 => [  //width
                '10 inches',
                '15 inches',
                '20 inches',
                '5 inches',
            ],
            4 => [ //weight
                '10 ounces',
                '15 ounces',
                '20 ounces',
                '50 ounces',
            ],
            5 => [  //capacity
                '6 gigabytes',
                '16 gigabytes',
                '32 gigabytes',
                '64 gigabytes',
                '128 gigabytes',
            ]
        ];

        $specs_count = count($this->specifications);
        $insert_values = [];

        foreach ($this->products as $product) {
            $values_count = ($r = random_int(
                	self::SPECS_PER_PRODUCT_RANGE[0],
                	self::SPECS_PER_PRODUCT_RANGE[1]
				)) > $specs_count ? $specs_count : $r;

            $insert_values = array_merge(
            	$insert_values, 
            	$this->makeValues(array_rand($this->specifications, $values_count), $product->getKey())
            );            
        }

        DB::table('products_specifications_values')->insert($insert_values);
    }

    private function makeValues($specs_ids, int $product_id)
    {
    	if (!is_array($specs_ids)) {
    		$specs_ids = [$specs_ids];
    	}

        $values = [];

        foreach ($specs_ids as $spec_id) {
        	$values[] = [
        		'specification_id' => $spec_id,
        		'product_id' => $product_id,
        		'value' => $this->specifications[$spec_id][
        			random_int(1, count($this->specifications[$spec_id]) - 1)
        		],
        	];
        }

        return $values;
    }
}
