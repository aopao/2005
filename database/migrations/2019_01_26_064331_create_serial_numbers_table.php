<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSerialNumbersTable.
 */
class CreateSerialNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serial_numbers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id')->default(0);
            $table->integer('agent_id')->default(0);
            $table->integer('student_id')->default(0);
            $table->integer('vip_id')->default(0)->comment('关联VIP卡类型');
            $table->string('number', 50)->unique()->index('number');
            $table->boolean('is_senior')->default(0)->comment('0:初级,1:高级,默认生成初级序列号');
            $table->boolean('channel')->default(0)->comment('发行渠道:0:线上,1:线下,2:未确定');
            $table->boolean('status')->default(0)->comment('0: 未使用,1:已使用,默认生成未使用序列号');
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
        Schema::drop('serial_numbers');
    }
}
