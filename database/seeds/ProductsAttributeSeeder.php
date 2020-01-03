<?php

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsAttributeSeeder extends Seeder
{
    private const ATTRS_PER_PRODUCT_RANGE = [1, 5];

    private $products = [];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->products = Product::get();

        $attributes = [
            'material' => [
                   '95% cotton 5% elasthane',
                   '100% cotton',
                   '80% cotton 20% elasthane',
                   "top fabric: 100% nylon \n
                   lining: 100% polyamide",
                   '98% cotton 2% elasthane',
                   "Upper: Synthetic Leather/Mesh;\n
                   Outsole: Molding EVA/RB",                
            ],
            'color' => [
                'black',
                'white',
                'orange',
                'red',
                'blue',
                'brown',
                'green',
            ],
        ];

        $all_values = $this->makeValues($attributes);
        $all_values_count = count($all_values);
        
        $insert_values = [];

        foreach ($this->products as $product) {
            $values_count = random_int(
                self::ATTRS_PER_PRODUCT_RANGE[0],
                self::ATTRS_PER_PRODUCT_RANGE[1]
            );
            for ($i=0; $i < $values_count; $i++) { 
                $insert_values[] = $all_values[random_int(0, $all_values_count - 1)];
                $insert_values[count($insert_values) - 1]['product_id'] = $product->getKey();
            }
        }

        DB::table('products_attributes')->insert($insert_values);
    }

    private function makeValues(array $attributes)
    {
        $values = [];

        foreach ($attributes as $attr_name => $cur_values) {
            array_walk($cur_values, function ($value) use ($attr_name, &$values) {
                $values[] = [
                    'name' => $attr_name,
                    'value' => $value,
                ];
            });
        }

        return $values;
    }

    public function getRandomProductID()
    {
        if (empty($this->products)) {
            $this->products = Product::all();
        }

        return $this->products->random()->getKey();
    }
}
