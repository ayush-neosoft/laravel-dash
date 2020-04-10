<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedIncrements('user_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('saica_number')->nullable();
            $table->string('irba_number')->nullable();
            $table->string('bill_name')->nullable();
            $table->string('bill_address_1')->nullable();
            $table->string('bill_address_2')->nullable();
            $table->string('bill_region')->nullable();
            $table->string('bill_postcode')->nullable();
            $table->string('bill_vat_number')->nullable();
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
        Schema::dropIfExists('user_details');
    }
}
