<?php

use Illuminate\Database\Seeder;
use App\Models\Channels\InfoModel as Models;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Models::truncate();
        for ($i=1;$i<=5;$i++){
            Models::create(['fid' => 0,'status' =>0,'title' =>'栏目'.$i,'description' =>'栏目'.$i.'描述','weight' =>0]);
        }
        factory(Models::class, 20)->create();
    }
}
