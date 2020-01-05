<?php

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsAttributeValueSeeder extends Seeder
{
    private const ATTRS_PER_PRODUCT_RANGE = [1, 5];

    private $products = [];
    private $attributes;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->products = Product::get();

        $this->attributes = [
            1 => [
                   '95% cotton 5% elasthane',
                   '100% cotton',
                   '80% cotton 20% elasthane',
                   "top fabric: 100% nylon \n
                   lining: 100% polyamide",
                   '98% cotton 2% elasthane',
                   "Upper: Synthetic Leather/Mesh;\n
                   Outsole: Molding EVA/RB",                
            ],
            2 => [
                'black',
                'white',
                'orange',
                'red',
                'blue',
                'brown',
                'green',
            ],
        ];
        $attrs_count = count($this->attributes);
        $insert_values = [];

        foreach ($this->products as $product) {
            $values_count = ($r = random_int(
                	self::ATTRS_PER_PRODUCT_RANGE[0],
                	self::ATTRS_PER_PRODUCT_RANGE[1]
				)) > $attrs_count ? $attrs_count : $r;

            $insert_values = array_merge(
            	$insert_values, 
            	$this->makeValues(array_rand($this->attributes, $values_count), $product->getKey())
            );            
        }

        DB::table('products_attributes_values')->insert($insert_values);
    }

    private function makeValues($attrs_ids, int $product_id)
    {
    	if (!is_array($attrs_ids)) {
    		$attrs_ids = [$attrs_ids];
    	}

        $values = [];

        foreach ($attrs_ids as $attr_id) {
        	$values[] = [
        		'attribute_id' => $attr_id,
        		'product_id' => $product_id,
        		'value' => $this->attributes[$attr_id][
        			random_int(1, count($this->attributes[$attr_id]) - 1)
        		],
        	];
        }

        return $values;
    }
}
