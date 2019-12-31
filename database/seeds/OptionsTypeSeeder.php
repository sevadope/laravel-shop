<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$types_names = [
            'Default',
    		'Body',
    		'Legs',
    		'Feet',
            'Outerwear',
    	];

    	DB::table('options_types')->insert($this->makeTypes($types_names));
    }

    private function makeTypes(array $types_names)
    {
    	$now = now();

    	return array_map(function ($type_name) use ($now) {
    		return [
    			'name' => $type_name,
    			'created_at' => $now,
    			'updated_at' => $now,
    		];
    	}, $types_names);
    }
}
