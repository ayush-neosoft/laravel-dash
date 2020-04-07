<?php

use App\Utils\AppConstant;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('year')->nullable();
            $table->string('position_title')->nullable();
            $table->tinyInteger('role_years')->nullable();
            $table->text('responsibility')->nullable();
            $table->text('competence_area')->nullable();
            $table->text('where_in_next_year')->nullable();
            $table->text('where_after_next_year')->nullable();
            $table->boolean('status')->default(AppConstant::STATUS_ACTIVE);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('plans');
    }
}
