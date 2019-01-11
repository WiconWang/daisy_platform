<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'messages';
        Schema::create($tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('uid')->unsigned()->nullable(false)->default(0)->comment('用户ID');
            $table->tinyInteger('user_type')->unsigned()->nullable(false)->default(0)->comment('用户类 0超管用户 1会员用户');
            $table->string('title',255)->nullable(false)->default('')->comment('信息标题');
            $table->text('content')->nullable(true)->default(null)->comment('信息内容');
            $table->tinyInteger('status')->unsigned()->nullable(false)->default(0)->comment('状态 0未读 1已读取 2已删除');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        DB::statement("ALTER TABLE `".DB::getTablePrefix().$tableName."` comment '消息通知总表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
