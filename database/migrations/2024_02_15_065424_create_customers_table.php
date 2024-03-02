<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('dealer_name');
            $table->string('material_type');
            $table->date('date_of_purchase');
            $table->string('country');
            $table->string('state')->nullable();
            $table->string('district');
            $table->string('color_of_sheets');
            $table->string('number_of_sheets');
            $table->string('serial_number');
            $table->string('thickness_of_sheets');
            $table->string('invoice');
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('customers');
    }
}
