<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsToOptionsValuesRelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_to_options_values_rel', function (Blueprint $table) {
            $table->bigInteger('product_id');
            $table->bigInteger('option_id');
            $table->bigInteger('value_id');

            $table->foreign('product_id')
                ->references('id')
                ->on('products');

            $table->foreign('option_id')
                ->references('id')
                ->on('products_options');

            $table->foreign('value_id')
                ->references('id')
                ->on('products_options_values');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_to_options_values_rel');
    }
}
