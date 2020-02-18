<?php

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsSpecificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specs = [
            'color',
            'height',
            'width',
            'weight',
            'total_storage_capacity',
        ];

        DB::table('products_specifications')->insert(array_map(
            function ($spec_name) {
                return [
                    'name' => $spec_name,
                ];
            }, 
            $specs
        ));
    }
}
