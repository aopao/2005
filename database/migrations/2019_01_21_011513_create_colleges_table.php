<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCollegesTable.
 */
class CreateCollegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colleges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->index('name');
            $table->string('english_name', 200)->unllable()->comment('学校英文名称');
            $table->string('logo', 200)->unllable()->comment('学校Logo');
            $table->string('code', 200)->unllable()->comment('学校代码');
            $table->integer('province_id')->default(0)->index('province_id');
            $table->integer('city_id')->default(0)->index('city_id');
            $table->integer('diplomas_id')->unllable()->index()->comment('层次|eg:本科/大专');
            $table->integer('category_id')->unllable()->index()->comment('科类|eg:工科类');
            $table->boolean('is_belong_to_edu')->default(0)->comment('是否从属教育部');
            $table->boolean('is_belong_to_center')->default(0)->comment('是否从属中央');
            $table->boolean('is_nation')->default(0)->comment('是否是公办');
            $table->boolean('is_985')->default(0)->comment('是否是985');
            $table->boolean('is_211')->default(0)->comment('是否是211');
            $table->boolean('is_top_college')->default(0)->comment('是否是一流大学');
            $table->string('since', 200)->unllable()->comment('建校时间');
            $table->string('doctor_number', 200)->unllable()->comment('博士数');
            $table->string('postgraduate_number', 200)->unllable()->comment('研究生数');
            $table->integer('general_rank')->comment('综合排名');
            $table->integer('graduate_rank')->default(0)->comment('毕业生质量排名');
            $table->integer('student_rank')->default(0)->comment('新生质量排名');
            $table->integer('teacher_rank')->default(0)->comment('教师水平排名');
            $table->integer('teacher_performance_rank')->default(0)->comment('教师绩效排名');
            $table->integer('wushulian_province_rank')->default(0)->comment('武书连省内排名');
            $table->integer('xyh_rank')->default(0)->comment('中国校友会排名');
            $table->string('life_rank', 200)->unllable()->comment('生活指数');
            $table->string('work_rank', 200)->unllable()->comment('工作指数');
            $table->integer('all_clicks')->default(0)->comment('总点击');
            $table->integer('month_clicks')->default(0)->comment('月点击');
            $table->integer('week_clicks')->default(0)->comment('周点击');
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
        Schema::drop('colleges');
    }
}
