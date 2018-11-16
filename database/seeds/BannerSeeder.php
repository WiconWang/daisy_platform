<?php

use Illuminate\Database\Seeder;
use App\Models\Component\BannerModel as Models;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Models::truncate();
        factory(Models::class, 20)->create();
    }
}
