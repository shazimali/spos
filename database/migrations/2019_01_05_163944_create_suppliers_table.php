<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name')->nullable();
            $table->string('email')->nullable();
            $table->text('company_name')->nullable();
            $table->text('phone1')->nullable();
            $table->text('phone2')->nullable();
            $table->text('passport_no')->nullable();
            $table->text('nic')->nullable();
            $table->string('city')->nullable();
            $table->longText('address1')->nullable();
            $table->longText('address2')->nullable();
            $table->decimal('balance',10,2)->default(0);
            $table->boolean('active')->default(true);
            $table->longText('remarks')->nullable();
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
        Schema::dropIfExists('suppliers');
    }
}
