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
            'color',
        ];

        DB::table('products_attributes')->insert(array_map(
            function ($attr_name) {
                return [
                    'name' => $attr_name,
                ];
            }, 
            $attributes
        ));
    }
}
