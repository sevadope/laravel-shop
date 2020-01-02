<?php

use Illuminate\Database\Seeder;
use App\Models\Product\Option;
use App\Models\Product;
use App\Models\Product\OptionValue;

class ProductsToOptionsValuesRelSeeder extends Seeder
{
	private const RELATIONS_COUNT = 600;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$products_count = Product::count();

    	$options = Option::with('values')->withCount('values')->get();

    	$relations = [];

        for ($i=0; $i < self::RELATIONS_COUNT; $i++) { 

        	$cur_option = $options->random();

       		$relations[] = [
       			'product_id' => random_int(1, $products_count),
       			'option_id' => $cur_option->getKey(),
       			'value_id' => $cur_option->values->random()->getKey(),
       		];
        }

        DB::table('products_to_options_values_rel')->insert($relations);
    }
}
