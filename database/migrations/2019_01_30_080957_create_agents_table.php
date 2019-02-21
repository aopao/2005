<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAgentsTable.
 */
class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile', 11)->index()->unique()->comment('也可用手机号登录,可不用');
            $table->string('password');
            $table->string('nickname', 100)->nullable();
            $table->string('rebates', 5)->default(0)->comment('账户返点');
            $table->string('email', 50)->nullable();
            $table->integer('qq')->nullable();
            $table->boolean('status')->default(1)->comment('账户状态0:禁封,1:正常');
            $table->string('verify_token', 128)->nullable()->comment('邮箱验证Token');
            $table->boolean('email_is_active')->default(0)->comment('邮箱是否已经验证,默认不认证');
            $table->rememberToken();
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
        Schema::drop('agents');
    }
}
