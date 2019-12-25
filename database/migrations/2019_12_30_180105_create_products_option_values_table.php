<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsOptionValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_option_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('option_id');
            $table->string('name');

            $table->foreign('option_id')
                ->references('id')
                ->on('products_options');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_option_values');
    }
}
