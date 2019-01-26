<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateProvinceControlScoresTable.
 */
class CreateProvinceControlScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('province_control_scores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('province_id')->index('province_id');
            $table->integer('year')->default(0)->index('year');
            $table->string('batch')->nullable();
            $table->integer('subject')->default(0);
            $table->integer('score')->default(0);
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
        Schema::drop('province_control_scores');
    }
}
