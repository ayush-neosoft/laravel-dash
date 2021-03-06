<?php

use App\Utils\AppConstant;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReflectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reflections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('activity_id');
            $table->string('outcome_activity')->nullable();
            $table->string('description')->nullable();
            $table->date('reflection_date')->nullable();
            $table->boolean('status')->default(AppConstant::STATUS_ACTIVE);
            // $table->foreign('activity_id')->references('id')->on('activity')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('reflections');
    }
}
