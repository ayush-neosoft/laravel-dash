<?php

use App\Utils\AppConstant;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevelopmentAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('development_area', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('plan_id');
            $table->string('plan_area');
            $table->text('description');
            $table->boolean('status')->default(AppConstant::STATUS_ACTIVE);
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('development_area');
    }
}
