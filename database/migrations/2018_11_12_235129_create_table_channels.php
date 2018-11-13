<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableChannels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'channels';
        Schema::create($tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('fid')->unsigned()->nullable(false)->default(0)->comment('上级频道');
            $table->tinyInteger('status')->unsigned()->nullable(false)->default(0)->comment('频道状态 0正常 1隐藏');
            $table->string('title',100)->nullable(false)->default('')->comment('频道标题');
            $table->string('description',250)->nullable(false)->default('')->comment('频道摘要');
            $table->Integer('weight')->unsigned()->nullable(false)->default(0)->comment('频道权重');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `".DB::getTablePrefix().$tableName."` comment '频道总表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('channels', function (Blueprint $table) {
            //
        });
    }
}
