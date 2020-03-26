<?php

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Order;

class OrderProductSeeder extends Seeder
{
	public const PRODUCTS_RANGE = [2, 5];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$order_product = [];
    	$products = Product::with('options')->get(['id']);
    	$orders = Order::get();


    	foreach ($orders as $order) {
    		$p_count = random_int(
    			self::PRODUCTS_RANGE[0],
    			self::PRODUCTS_RANGE[1]
    		);

    		for ($i=0; $i < $p_count; $i++) { 
    			$product = $products->random(1)->first();
    			$options = $this->getRandomOptions($product);

    			$order_product[] = $this->makeRow(
    				$order->getKey(),
    				$product->getKey(),
    				$options
    			);
    		}
    	}

        DB::table('order_product')->insert($order_product);
    }

    private function makeRow(
    	int $order_id,
    	int $product_id,
    	array $options
    )
    {
    	return [
    		'order_id' => $order_id,
    		'product_id' => $product_id,
    		'options' => json_encode($options),
    	];
    }

    private function getRandomOptions(Product $product)
    {
    	$options = [];

    	foreach ($product->options as $option) {
    		$options[$option->name] = $option->values->random(1)->first()->value;
    	}

    	return $options;
    }
}
