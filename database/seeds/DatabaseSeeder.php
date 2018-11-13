<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserInfoSeeder::class);
        $this->call(AdminInfoSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(ChannelSeeder::class);
    }
}
