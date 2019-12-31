<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsOptionsSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$sets_names = [
            'Default',
    		'Body',
    		'Legs',
    		'Feet',
            'Outerwear',
    	];

    	DB::table('products_options_sets')->insert($this->makeSets($sets_names));
    }

    private function makeSets(array $sets_names)
    {
    	$now = now();

    	return array_map(function ($set_name) use ($now) {
    		return [
    			'name' => $set_name,
    			'created_at' => $now,
    			'updated_at' => $now,
    		];
    	}, $sets_names);
    }
}
