zz<?php

use Illuminate\Database\Seeder;
use App\Models\Product\Option;
use App\Models\Product;
use App\Models\Product\OptionValue;

class ProductsToOptionsValuesRelSeeder extends Seeder
{
    private const OPTIONS_PER_PRODUCT_RANGE = [1, 2];
    private const VALUES_PER_OPTION_RANGE = [1, 3];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$products_count = Product::count();
    	$options = Option::with('all_values')->withCount('all_values')->get();

    	$relations = [];

        for ($product_id = 1; $product_id <= $products_count; $product_id++) {

            $options_count = $this->getRandomOptionsCount();

            foreach ($options->random($options_count) as $option) {     
                $values_count = $this->getRandomValuesCount();

                foreach ($option->all_values->random($values_count) as $value) {
                    $relations[] = $this->makeRow($value->id, $product_id);
                }
            }
        }

        DB::table('products_to_options_values_rel')->insert($relations);
    }

    private function getRandomOptionsCount()
    {
        return random_int(
            self::OPTIONS_PER_PRODUCT_RANGE[0],
            self::OPTIONS_PER_PRODUCT_RANGE[1]
        );
    }

    private function getRandomValuesCount()
    {
        return random_int(
            self::VALUES_PER_OPTION_RANGE[0],
            self::VALUES_PER_OPTION_RANGE[1]
        );
    }   


    private function makeRow(int $value_id, int $product_id)
    {
        return [
            'value_id' => $value_id,
            'product_id' => $product_id,
        ];
    }
}
