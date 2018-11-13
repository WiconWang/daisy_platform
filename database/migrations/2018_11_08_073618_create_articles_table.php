<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'articles';
        Schema::create($tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('cid')->unsigned()->nullable(false)->default(0)->comment('文章所属频道');
            $table->tinyInteger('status')->unsigned()->nullable(false)->default(0)->comment('文章状态 0正常 1隐藏');
            $table->string('flag',20)->nullable(false)->default('')->comment('文章特殊标记 逗号分隔 头条h 推荐c 图片p 幻灯f 滚动s');
            $table->string('title',100)->nullable(false)->default('')->comment('标题');
            $table->string('short_title',40)->nullable(false)->default('')->comment('短摘要');
            $table->string('description',250)->nullable(false)->default('')->comment('摘要');
            $table->string('keyword',100)->nullable(false)->default('')->comment('关键词');
            $table->Integer('author_id')->unsigned()->nullable(false)->default(0)->comment('作者ID');
            $table->string('author_name',100)->nullable(false)->default('')->comment('作者姓名');
            $table->tinyInteger('author_site')->unsigned()->nullable(false)->default(0)->comment('作者渠道 0默认前台 1默认后台对应管理员');
//            $table->enum('author_site', ['0', '1'])->nullable(true)->default('0')->comment('作者渠道 0默认前台 1默认后台对应管理员');
            $table->Integer('weight')->unsigned()->nullable(false)->default(0)->comment('文章权重');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `".DB::getTablePrefix().$tableName."` comment '文章总表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
