<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
	private const ROLES = [
		'public',
		'moderator',
		'admin',
		'super_admin'
	];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$roles_table = [];

    	foreach (AuthSeeder::ROLES as $name) {
    		$roles_table[] = $this->makeRow($name);
    	}

    	DB::table('roles')->insert($roles_table);
    }

    private function makeRow(string $name)
    {
    	return [
    		'name' => $name,
    	];
    }
}
