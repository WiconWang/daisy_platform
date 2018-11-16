<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBanners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'banners';
        Schema::create($tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',255)->nullable(false)->default('')->comment('焦点图标题');
            $table->string('short_title',100)->nullable(false)->default('')->comment('小标题');
            $table->string('description',255)->nullable(false)->default('')->comment('焦点图摘要');
            $table->string('pic_url',100)->nullable(false)->default('')->comment('图片地址');
            $table->string('link_url',255)->nullable(false)->default('')->comment('图片连接');
            $table->Integer('classification')->unsigned()->nullable(false)->default(0)->comment('所属分类');
            $table->tinyInteger('status')->unsigned()->nullable(false)->default(0)->comment('用户状态 0正常 1禁用');
            $table->timestamp('out_date')->nullable(true)->comment('图片过期时间');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        DB::statement("ALTER TABLE `".DB::getTablePrefix().$tableName."` comment '焦点图总表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
}
