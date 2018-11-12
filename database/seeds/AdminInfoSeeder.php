<?php
//php artisan make:seeder AdminInfoSeeder
use Illuminate\Database\Seeder;
use App\Models\Admin\InfoModel as Models;

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
        factory(Models::class, 50)->create();
    }
}
