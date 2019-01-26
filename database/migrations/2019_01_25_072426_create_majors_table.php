<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMajorsTable.
 */
class CreateMajorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('majors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->comment('分类名称');
            $table->string('code', 20)->comment('专业分类ID');
            $table->integer('parent_id')->default(0)->comment('上级分类 ID');
            $table->integer('top_parent_id')->default(0)->comment('根分类 ID');
            $table->string('awarded_degree')->nullable()->comment('毕业授予学位');
            $table->integer('diplomas')->default(0)->comment('专业层次0:专科|1:本科');
            $table->integer('ranking')->default(0)->comment('排名');
            $table->integer('ranking_type')->default(0)->comment('同专业内排名');
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
        Schema::drop('majors');
    }
}
