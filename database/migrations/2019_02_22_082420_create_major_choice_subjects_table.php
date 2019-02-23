<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMajorChoiceSubjectsTable.
 */
class CreateMajorChoiceSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('major_choice_subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('major_name');
            $table->integer('college_id')->default(0);
            $table->integer('province_id')->default(0);
            $table->integer('year')->default(0);
            $table->integer('major_num')->default(1);
            $table->integer('degree')->default(1)->comment('层次,0:专科,1:本科');
            $table->integer('major_limit')->default(0)->comment('-1:无限制,忽略后边的科目选择,0:有限制,以科目选择为准');
            $table->integer('physics')->default(-1)->comment('-1:无限制,0:可选,1:必选');
            $table->integer('chemistry')->default(-1)->comment('-1:无限制,0:可选,1:必选');
            $table->integer('biology')->default(-1)->comment('-1:无限制,0:可选,1:必选');
            $table->integer('history')->default(-1)->comment('-1:无限制,0:可选,1:必选');
            $table->integer('politics')->default(-1)->comment('-1:无限制,0:可选,1:必选');
            $table->integer('geography')->default(-1)->comment('-1:无限制,0:可选,1:必选');
            $table->integer('extra')->default(-1)->comment('-1:无限制,0:可选,1:必选');
            $table->text('detail')->nullable();
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
        Schema::drop('major_choice_subjects');
    }
}
