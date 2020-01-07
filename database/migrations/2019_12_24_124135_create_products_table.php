<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id');

            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->integer('popularity')->default(0);
            $table->jsonb('attributes')->nullable();

            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('categories');
        });

        DB::connection()->getPdo()->exec(
            'ALTER TABLE products 
                ADD COLUMN price money;'
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
