<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$permissions = [];

        foreach (AuthSeeder::VERBS as $verb) {
        	foreach (AuthSeeder::ENTITIES as $class => $alias) {
        		$permissions[] = $this->makeRow($verb, $alias);
        	}
        }

        DB::table('permissions')->insert($permissions);
    }
    
    private function makeRow(string $verb, string $alias)
    {
    	return [
    		'can' => AuthSeeder::makeAction($verb, $alias),
    	];
    }

}
