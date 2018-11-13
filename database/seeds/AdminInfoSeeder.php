<?php
//php artisan make:seeder AdminInfoSeeder
use Illuminate\Database\Seeder;
use App\Models\Admins\InfoModel as Models;

class AdminInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Models::truncate();
        Models::create([
            'mobile' => '18000000000',
            'password' => bcrypt(123456),
            'username' => '超级管理员',
            'email' => 'email@email.com',
            'level' => 1,
            'status' => 0
        ]);
        factory(Models::class, 10)->create();
    }
}
