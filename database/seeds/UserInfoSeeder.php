<?php

use Illuminate\Database\Seeder;
use App\Models\User\InfoModel as Models;

class UserInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Models::truncate();
        factory(Models::class, 50)->create();
    }
}
