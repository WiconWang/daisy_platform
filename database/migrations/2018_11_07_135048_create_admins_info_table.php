<?php
// php artisan make:migration create_admins_info_table  --create=admins_info
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'admins_info';
        Schema::create($tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',22)->nullable(false)->default('')->unique()->comment('用户手机号');
            $table->string('mobile',14)->nullable(false)->default('')->unique()->comment('用户手机号');
            $table->string('email',100)->nullable(false)->default('')->comment('用户邮箱');
            $table->string('password')->nullable(false)->default('')->comment('登陆密码');
            $table->string('cover')->nullable(false)->default('')->comment('封面头像');
            $table->tinyInteger('level')->unsigned()->nullable(false)->default(0)->comment('用户级别');
            $table->tinyInteger('status')->unsigned()->nullable(false)->default(0)->comment('用户状态 0正常 1禁用');
            $table->timestamp('out_date')->nullable(true)->comment('过期时间');
            $table->timestamp('last_login')->nullable(true)->comment('最后登陆时间');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        DB::statement("ALTER TABLE `".DB::getTablePrefix().$tableName."` comment '超级管理员总表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins_info');
    }
}
