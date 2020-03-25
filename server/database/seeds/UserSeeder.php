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
    	
		$factory->of(User::class, 'public')->times(10)->create();
		$factory->of(User::class, 'manager')->times(10)->create();
		$factory->of(User::class, 'admin')->times(3)->create();
		$factory->of(User::class, 'super_admin')->times(1)->create();

        DB::table('users')->insert([
            [
                'role' => 'admin', 
                'first_name'  => 'ad',
                'last_name' => 'min',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ],
        ]);
    }
}
