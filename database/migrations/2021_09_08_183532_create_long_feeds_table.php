<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLongFeedsTable extends Migration
{
    public function up()
    {
        Schema::create('long_feeds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('chunk');
            $table->text('xml_url')->nullable();
            $table->string('slug');
            $table->string('last_update')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('long_feeds');
    }
}
