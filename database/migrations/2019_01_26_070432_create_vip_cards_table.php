<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateVipsTable.
 */
class CreateVipCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vip_cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->index('name');
            $table->string('low_price')->default(0);
            $table->string('high_price')->default(0);
            $table->integer('xgkxk')->default(-1)->comment('新高考选科报告');
            $table->integer('gjkmxzy')->default(-1)->comment('根据科目选专业');
            $table->integer('gjzyxkm')->default(-1)->comment('根据专业选科目');
            $table->integer('ljdxzy')->default(-1)->comment('了解大学专业');
            $table->integer('zyzyt')->default(-1)->comment('专业职业通');
            $table->integer('tswlzy')->default(-1)->comment('探索未来职业');
            $table->integer('zyxgcs')->default(-1)->comment('职业性格测试');
            $table->integer('sxtjzn')->default(-1)->comment('升学途径指南');
            $table->integer('sxtjfx')->default(-1)->comment('升学途径分析');
            $table->integer('xxfgcp')->default(-1)->comment('学习风格测评');
            $table->integer('sjglcy')->default(-1)->comment('时间管理测验');
            $table->integer('xltjcy')->default(-1)->comment('心理调节测验');
            $table->integer('qxglcy')->default(-1)->comment('情绪管理测验');
            $table->integer('zzyxdw')->default(-1)->comment('自招院校定位');
            $table->integer('zzyxcx')->default(-1)->comment('自招院校查询');
            $table->integer('cshzy')->default(-1)->comment('测适合专业');
            $table->integer('zzhdsj')->default(-1)->comment('自招活动数据');
            $table->integer('zzsjfx')->default(-1)->comment('自招数据分析');
            $table->integer('zzyxxb')->default(-1)->comment('自招院校限报');
            $table->integer('znxxx')->default(-1)->comment('智能选学校');
            $table->integer('lqfxpg')->default(-1)->comment('录取风险评估');
            $table->integer('twcksqx')->default(-1)->comment('同位次考生去向');
            $table->integer('tfksqx')->default(-1)->comment('同分考生去向');
            $table->integer('zydzbg')->default(-1)->comment('志愿定制报告');
            $table->integer('zyfscx')->default(-1)->comment('专业分数线查询');
            $table->integer('yfydb')->default(-1)->comment('一分一段表');
            $table->integer('skxfscx')->default(-1)->comment('省控分数线查询');
            $table->integer('gxcx')->default(-1)->comment('高校查询');
            $table->integer('gxfscx')->default(-1)->comment('高校分数线查询');
            $table->integer('dxpm')->default(-1)->comment('大学排名');
            $table->integer('zycx')->default(-1)->comment('专业查询');
            $table->boolean('status')->default(1)->comment('状态');
            $table->string('description')->nullable();
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
        Schema::drop('vip_cards');
    }
}
