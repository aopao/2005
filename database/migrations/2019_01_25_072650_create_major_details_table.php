<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMajorDetailsTable.
 */
class CreateMajorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('major_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('major_id')->comment('专业 ID');
            $table->integer('clicks')->default(0)->comment('总点击');
            $table->string('job_direction')->nullable()->comment('就业方向');
            $table->string('graduation_student_num')->default(0)->comment('毕业学生数');
            $table->string('work_rate')->default('0')->comment('就业率');
            $table->string('wen_ratio')->default('0')->comment('文科比例');
            $table->string('li_ratio')->default('0')->comment('理科比例');
            $table->string('male_ratio')->default('0')->comment('男生比例');
            $table->string('female_ratio')->default('0')->comment('女生比例');
            $table->text('description')->nullable()->comment('简介');
            $table->text('goal')->nullable()->comment('目标');
            $table->text('require')->nullable()->comment('要求');
            $table->text('obtain')->nullable()->comment('获得');
            $table->text('subject')->nullable()->comment('学科');
            $table->text('course')->nullable()->comment('课程');
            $table->text('teach')->nullable()->comment('学习');
            $table->text('year')->nullable()->comment('年限');
            $table->text('degree')->nullable()->comment('学位');
            $table->text('jobs')->nullable()->comment('从事的职业');
            $table->text('male_trait')->nullable()->comment('适合此专业的男生特质');
            $table->text('female_trait')->nullable()->comment('适合此专业的女生特质');
            $table->text('employment_type')->nullable()->comment('就业方向--行业分布');
            $table->text('employment_city')->nullable()->comment('就业方向--城市分布');
            $table->text('money')->nullable()->comment('就业方向--薪酬');
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
        Schema::drop('major_details');
    }
}
