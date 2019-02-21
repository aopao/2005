<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateArticlesTable.
 */
class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id')->default(0);
            $table->integer('agent_id')->default(0);
            $table->integer('article_category_id');
            $table->string('source_id')->comment('文章来源');
            $table->string('title');
            $table->string('excerpt')->nullable()->comment('文章摘要');
            $table->string('thumb')->nullable()->comment('缩略图');
            $table->text('content');
            $table->integer('views')->default(0);
            $table->integer('is_top')->default(0)->comment('是否置顶默认0,1:本分类置顶,2:全局置顶');
            $table->integer('is_remark')->default(0)->comment('是否首页推荐默认0,1:推荐');
            $table->string('http_url')->nullable()->comment('如果设置可直接跳转一个地址');
            $table->string('status')->default(0)->comment('文章当前的状态0:未发布,1:发布,-1:待审核');
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
        Schema::drop('articles');
    }
}
