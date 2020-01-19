<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factory;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$factory = app(Factory::class);
    	
		$factory->of(User::class, 'public')->times(1000)->create();
		$factory->of(User::class, 'moderator')->times(10)->create();
		$factory->of(User::class, 'admin')->times(3)->create();
		$factory->of(User::class, 'super_admin')->times(1)->create();
    }
}
