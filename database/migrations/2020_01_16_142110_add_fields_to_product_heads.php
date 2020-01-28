<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToProductHeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_heads', function (Blueprint $table) {

            $table->integer('unit_id')->default(0)->code();
            $table->integer('brand_id')->default(0)->code();
       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_heads', function (Blueprint $table) {
            //
        });
    }
}
