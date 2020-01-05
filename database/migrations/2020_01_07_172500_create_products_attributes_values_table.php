<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsAttributesValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_attributes_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('attribute_id');
            $table->bigInteger('product_id');

            $table->string('value');

            $table->foreign('product_id')
                ->references('id')
                ->on('products');
        
            $table->foreign('attribute_id')
                ->references('id')
                ->on('products_attributes');

            $table->unique(['attribute_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_attributes_values');
    }
}
