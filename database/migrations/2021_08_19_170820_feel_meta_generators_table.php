<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\MetaGenerators;

class FeelMetaGeneratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        MetaGenerators::create( [ 'name' => 'Filter', 'type' => 'filter'] );
        MetaGenerators::create( [ 'name' => 'Category', 'type' => 'category'] );
        MetaGenerators::create( [ 'name' => 'Product', 'type' => 'product'] );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        MetaGenerators::whereIn('type', ['filter','category','product'])->forceDelete();
    }
}
