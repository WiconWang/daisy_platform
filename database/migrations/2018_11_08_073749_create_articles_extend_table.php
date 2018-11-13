<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesExtendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'articles_extend';
        Schema::create($tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('aid')->unsigned()->nullable(false)->default(0)->comment('文章ID');
            $table->text('content')->nullable(true)->comment('文章内容区');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `".DB::getTablePrefix().$tableName."` comment '文章扩展表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles_extend');
    }
}
