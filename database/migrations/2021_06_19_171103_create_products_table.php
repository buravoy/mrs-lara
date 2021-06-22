<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->integer('category_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->float('price')->nullable();
            $table->float('old_price')->nullable();
            $table->float('discount')->nullable();
            $table->string('brand')->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->integer('sort')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
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
