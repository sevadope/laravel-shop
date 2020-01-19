<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AuthSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductsOptionSeeder::class);
        $this->call(ProductsOptionValueSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ProductsSpecificationSeeder::class);
        $this->call(ProductsSpecificationValueSeeder::class);
        $this->call(ProductsToOptionsValuesRelSeeder::class);
    }
}
