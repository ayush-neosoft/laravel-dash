<?php

use App\Utils\AppConstant;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('development_area_id');
            $table->string('activity_type');
            $table->string('activity');
            $table->date('potential_date');
            $table->date('actual_date');
            $table->boolean('is_completed')->default(AppConstant::STATUS_INACTIVE);
            $table->boolean('status')->default(AppConstant::STATUS_ACTIVE);
            // $table->foreign('development_area_id')->references('id')->on('development_area')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('activity');
    }
}
