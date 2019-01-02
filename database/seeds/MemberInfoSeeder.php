<?php

use Illuminate\Database\Seeder;
use App\Models\Members\InfoModel as Models;

class MemberInfoSeeder extends Seeder
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
