<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;

class OrderSeeder extends Seeder
{
	public const ORDERS_TO_USERS = 1.2;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$orders = [];
    	$users = User::get();
    	$orders_count = round($users->count() * self::ORDERS_TO_USERS);

    	for ($i=0; $i < $orders_count; $i++) { 
    		$orders[] = $this->makeRow(
    			$users->random(1)->first()->getKey()	
    		);
    	}

		DB::table('orders')->insert($orders);
    }

    private function makeRow(string $user_id)
    {
    	return [
    		'customer_id' => $user_id,
            'total_price' => random_int(500, 20000),
            'payment_id' => Str::random(20),
            'status' => $this->getRandStatus(),
    		'created_at' => now(),
    		'updated_at' => now(),
    	];
    }

    private function getRandStatus()
    {
        return ($this->states ?? $this->states = [
                Order::PENDING,
                Order::PROCESSING,
                Order::SUCCEEDED
            ])[array_rand($this->states)];
    }
}
