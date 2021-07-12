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
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->text('description_1')->nullable();
            $table->text('description_2')->nullable();
            $table->text('image')->nullable();
            $table->text('href')->nullable();
            $table->string('uniq_id')->nullable();
            $table->float('price')->nullable();
            $table->float('old_price')->nullable();
            $table->float('discount')->nullable();
            $table->float('rating')->nullable();
            $table->jsonb('attributes')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
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
