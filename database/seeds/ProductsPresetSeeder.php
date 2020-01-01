<?php

use Illuminate\Database\Seeder;

class ProductsPresetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$presets_names = [
            'Default',
    		'Body',
    		'Legs',
    		'Feet',
            'Outerwear',
    	];

    	DB::table('products_presets')->insert($this->makePresets($presets_names));
    }

    private function makePresets(array $presets_names)
    {
    	$now = now();

    	return array_map(function ($preset_name) use ($now) {
    		return [
    			'name' => $preset_name,
    			'created_at' => $now,
    			'updated_at' => $now,
    		];
    	}, $presets_names);
    }
}
